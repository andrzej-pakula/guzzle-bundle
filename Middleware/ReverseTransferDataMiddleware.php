<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\RequestOptions;
use Andreo\GuzzleBundle\DataTransfer\DataMapperRegistry;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformer;
use Andreo\GuzzleBundle\Response\Response;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

final class ReverseTransferDataMiddleware implements InvokableMiddlewareInterface
{
    use InvokableMiddlewareTrait;

    private DataMapperRegistry $dataMapperRegistry;

    public function __construct(DataMapperRegistry $dataMapperRegistry)
    {
        $this->dataMapperRegistry = $dataMapperRegistry;
    }

    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        return $nextHandler($request, $options)->then(
            function (ResponseInterface $response) use ($request, $options) {
                $responseDecorator = new Response($response);
                /** @var DTOInterface|null $dto */
                $dto = $options[RequestOptions::DTO];
                if (null === $dto) {
                    return $response;
                }

                $dataMapper = $this->dataMapperRegistry->get($options[RequestOptions::FORMAT]);
                $transformer = $dto->reverseTransfer($dataMapper, new ResponseTransformer($responseDecorator));

                return $transformer->getResponse();
            }
        );
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->unshift(new InvokableMiddlewareHandler($this), self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }

    public function supports(array $config): bool
    {
        return $config[RequestOptions::DTO_SUPPORTS];
    }
}