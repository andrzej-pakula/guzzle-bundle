<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

trait MiddlewareTrait
{
    private MiddlewareHandler $nextHandler;

    public function withNextHandler(MiddlewareHandler $handler): MiddlewareInterface
    {
        /** @var MiddlewareInterface&MiddlewareTrait $this */
        $new = clone $this;
        $new->nextHandler = $handler;

        return $new;
    }

    private function getNextHandler(): MiddlewareHandler
    {
        return $this->nextHandler;
    }
}