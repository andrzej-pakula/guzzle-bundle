<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Configurator;

use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareStorageInterface;

final class ConfigBuilder implements ConfigBuilderInterface
{
    private DelegatingConfigBuilderInterface $delegatingConfigBuilder;
    private MiddlewareStorageInterface $middlewareStorage;
    private string $clientName;

    public function __construct(
        string $clientName,
        DelegatingConfigBuilderInterface $delegatingConfigBuilder,
        MiddlewareStorageInterface $middlewareStorage
    ){
        $this->clientName = $clientName;
        $this->delegatingConfigBuilder = $delegatingConfigBuilder;
        $this->middlewareStorage = $middlewareStorage;
    }

    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface
    {
        $this->setMiddlewares($configurator, $this->clientName);

        return $this->delegatingConfigBuilder->build($configurator);
    }

    private function setMiddlewares(ConfiguratorInterface $configurator, string $clientName): void
    {
        $middlewares = $this->middlewareStorage->get($clientName);
        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares  as $middleware) {
            $configurator->addMiddleware($middleware);
        }
    }
}