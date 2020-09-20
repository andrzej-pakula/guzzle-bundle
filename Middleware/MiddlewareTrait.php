<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

trait MiddlewareTrait
{
    /** @var callable */
    private $next;

    public function withNext(callable $next): MiddlewareInterface
    {
        /** @var MiddlewareInterface&MiddlewareTrait $this */
        $new = clone $this;
        $new->next = $next;

        return $new;
    }
}
