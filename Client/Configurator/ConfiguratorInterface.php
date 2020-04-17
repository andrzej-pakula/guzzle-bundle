<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


use Andreo\GuzzleBundle\Client\ClientInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;

interface ConfiguratorInterface
{
    /**
     * @return string&ClientInterface
     */
    public function getDecoratorClass(): ?string;

    public function addMiddleware(MiddlewareInterface $middleware): void;

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array;
}