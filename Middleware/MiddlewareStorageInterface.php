<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;


interface MiddlewareStorageInterface
{
    /**
     * @return iterable<MiddlewareInterface>
     */
    public function get(string $clientName): iterable;
}