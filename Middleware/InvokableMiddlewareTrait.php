<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

trait InvokableMiddlewareTrait
{
    /** @var callable */
    private $nextHandler;

    public function withNextHandler(callable $handler): InvokableMiddlewareInterface
    {
        /** @var InvokableMiddlewareInterface&InvokableMiddlewareTrait $this */
        $new = clone $this;
        $new->nextHandler = $handler;

        return $new;
    }

    /**
     * @return callable
     */
    public function getNextHandler(): callable
    {
        return $this->nextHandler;
    }
}
