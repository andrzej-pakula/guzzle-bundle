<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;


use Andreo\GuzzleBundle\RegistryInterface;

interface MiddlewareRegistryInterface
{
    /**
     * @return iterable<MiddlewareInterface>
     */
    public function get(string $clientName): iterable;
}