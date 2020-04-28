<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

final class InvokableMiddlewareHandler
{
    private InvokableMiddlewareInterface $middleware;

    public function __construct(InvokableMiddlewareInterface $middleware)
    {
        $this->middleware = $middleware;
    }

    public function __invoke(callable $nextHandler): InvokableMiddlewareInterface
    {
        return $this->middleware->withNextHandler($nextHandler);
    }
}