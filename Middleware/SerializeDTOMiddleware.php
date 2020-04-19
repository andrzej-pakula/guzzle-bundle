<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class SerializeDTOMiddleware implements MiddlewareInterface
{
    use MiddlewareTrait;

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        return $nextHandler($request, $options);
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->push(new MiddlewareHandler($this), self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }
}