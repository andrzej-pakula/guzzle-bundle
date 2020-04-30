<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;

interface ConfiguratorInterface extends ConfigProviderInterface
{
    public function addMiddleware(MiddlewareInterface $middleware): void;
}