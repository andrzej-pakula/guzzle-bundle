<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Generator;

final class MiddlewareStorage implements MiddlewareStorageInterface
{
    /** @var array<string, MiddlewareInterface>  */
    private array $middlewares;

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function __construct(iterable $middlewares)
    {
        $this->setMiddlewares($middlewares);
    }

    /**
     * @return iterable<MiddlewareInterface>
     */
    public function get(string $clientName): Generator
    {
        yield from array_merge($this->middlewares[$clientName] ?? [], $this->middlewares['default'] ?? []);
    }

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    private function setMiddlewares(iterable $middlewares): void
    {
        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $this->middlewares[$middleware->getClientName() ?? 'default'][] = $middleware;
        }
    }
}