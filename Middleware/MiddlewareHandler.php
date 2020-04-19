<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

final class MiddlewareHandler
{
    private MiddlewareInterface $middleware;

    public function __construct(MiddlewareInterface $middleware)
    {
        $this->middleware = $middleware;
    }

    public function __invoke(callable $nextHandler): MiddlewareInterface
    {
        return $this->middleware->withNextHandler($nextHandler);
    }
}