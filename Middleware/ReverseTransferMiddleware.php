<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\RequestOptions;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformerInterface;
use Andreo\GuzzleBundle\Request\Response;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

final class ReverseTransferMiddleware implements MiddlewareInterface
{
    use MiddlewareTrait;

    private ResponseTransformerInterface $responseTransformer;

    public function __construct(ResponseTransformerInterface $responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;
    }

    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        return $nextHandler($request, $options)->then(
            function (ResponseInterface $response) use ($request, $options) {
                /** @var DTOInterface $dto */
                $dto = $options[RequestOptions::DTO];

                $responseDecorator = new Response($response);

                return $dto->reverseTransfer($responseDecorator, $this->responseTransformer);
            }
        );
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->unshift(new MiddlewareHandler($this), self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }
}