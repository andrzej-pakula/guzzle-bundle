<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;


interface MiddlewareSupportsInterface
{
    /**
     * @param array<string, mixed> $config
     */
    public function supports(array $config): bool;
}