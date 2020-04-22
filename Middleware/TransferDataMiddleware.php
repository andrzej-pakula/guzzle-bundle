<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\RequestOptions;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformerInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class TransferDataMiddleware implements MiddlewareInterface
{
    use MiddlewareTrait;

    private RequestTransformerInterface $requestTransformer;

    public function __construct(RequestTransformerInterface $requestTransformer)
    {
        $this->requestTransformer = $requestTransformer;
    }

    /**
     * @param Request&RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        /** @var DTOInterface $dto */
        $dto = $options[RequestOptions::DTO];

        $request = $dto->transfer($request, $this->requestTransformer);
        
        return $nextHandler($request, $options);
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->before('prepare_body', new MiddlewareHandler($this), self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }
}