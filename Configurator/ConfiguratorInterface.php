<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;

interface ConfiguratorInterface
{
    public function addMiddleware(MiddlewareInterface $middleware): void;

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array;
}