<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;


interface MiddlewareInterface
{
    /**
     * @return string&ClientInterface
     */
    public function getClientName(): ?string;

    public function apply(HandlerStack $stack): void;

    /**
     * @param array<string, mixed> $config
     */
    public function supports(array $config): bool;
}