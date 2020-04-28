<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\RequestOptions;
use Andreo\GuzzleBundle\DataTransfer\DataMapperInterface;
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

    private DataMapperInterface $dataMapper;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
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

                $transformer = $dto->reverseTransfer($this->dataMapper, new ResponseTransformer($responseDecorator));

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
}