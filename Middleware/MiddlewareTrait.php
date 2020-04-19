<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

trait MiddlewareTrait
{
    /** @var callable */
    private $nextHandler;

    public function withNextHandler(callable $handler): MiddlewareInterface
    {
        /** @var MiddlewareInterface&MiddlewareTrait $this */
        $new = clone $this;
        $new->nextHandler = $handler;

        return $new;
    }

    public function getNextHandler(): callable
    {
        return $this->nextHandler;
    }
}