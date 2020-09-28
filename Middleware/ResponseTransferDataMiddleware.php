<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Request\Options;
use Andreo\GuzzleBundle\DataTransfer\DataMapperLocator;
use Andreo\GuzzleBundle\DataTransfer\DataTransferInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformer;
use Andreo\GuzzleBundle\Response\Response;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseTransferDataMiddleware implements MiddlewareInterface, MiddlewareSupportsInterface
{
    use MiddlewareTrait;

    private DataMapperLocator $dataMapperLocator;

    public function __construct(DataMapperLocator $dataMapperLocator)
    {
        $this->dataMapperLocator = $dataMapperLocator;
    }

    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->next;

        return $nextHandler($request, $options)->then(
            function (ResponseInterface $response) use ($request, $options) {
                /** @var DataTransferInterface|null $dto */
                $dto = $options[Options::DTO] ??= null;

                if ($dto instanceof DataTransferInterface) {
                    $dataMapper = $this->dataMapperLocator->get($options[Options::DATA_TRANSFER][Options::FORMAT]);
                    $transformer = $dto->reverseTransfer(new ResponseTransformer(new Response($response), $dataMapper));
                    $response = $transformer->getResponse();
                }

                return $response;
            }
        );
    }

    public function join(HandlerStack $stack): void
    {
        $stack->unshift(new MiddlewareHandler($this), self::class);
    }

    public function supports(string $clientName, array $options): bool
    {
        return $options[Options::DATA_TRANSFER]['enabled'];
    }
}
