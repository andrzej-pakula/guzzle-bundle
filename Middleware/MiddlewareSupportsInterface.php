<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;


interface MiddlewareSupportsInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function supports(string $clientName, array $options): bool;
}