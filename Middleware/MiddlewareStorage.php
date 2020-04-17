<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;


final class MiddlewareStorage implements MiddlewareStorageInterface
{
    /** @var array<string, MiddlewareHandler>  */
    private array $middlewares;

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function __construct(iterable $middlewares)
    {
        $this->setCreatedHandlers($middlewares);
    }

    public function get(string $clientName): iterable
    {
        return $this->middlewares[$clientName] ?? [];
    }

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    private function setCreatedHandlers(iterable $middlewares): void
    {
        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $this->middlewares[$middleware->getClientName()][] = new MiddlewareHandler($middleware);
        }
    }
}