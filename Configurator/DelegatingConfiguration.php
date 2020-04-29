<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareStorageInterface;

final class DelegatingConfiguration implements DelegatingConfiguratorInterface
{
    private MiddlewareStorageInterface $middlewareStorage;

    private string $clientName;

    /** @var array<string, mixed> */
    private array $configuration;

    public function __construct(MiddlewareStorageInterface $middlewareStorage, string $clientName, array $configuration)
    {
        $this->middlewareStorage = $middlewareStorage;
        $this->clientName = $clientName;
        $this->configuration = $configuration;
    }

    public function configure(ConfiguratorInterface $configurator): void
    {
        $middlewares = $this->middlewareStorage->get($this->clientName);

        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $configurator->addMiddleware($middleware);
        }

        $configurator->config = $this->configuration['options'];
        $configurator->config['base_uri'] = $this->configuration['base_uri'];
    }
}