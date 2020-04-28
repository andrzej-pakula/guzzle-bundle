<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareStorageInterface;

final class ConfigBuilder implements ConfigBuilderInterface
{
    private MiddlewareStorageInterface $middlewareStorage;

    /** @var Configurator&ConfiguratorInterface  */
    private ConfiguratorInterface $configurator;

    private ConfigProviderInterface $configProvider;

    /** @var array<string, mixed> */
    private array $config;

    public function __construct(
        MiddlewareStorageInterface $middlewareStorage,
        ConfiguratorInterface $configurator,
        ConfigProviderInterface $configProvider,
        array $config
    ){
        $this->middlewareStorage = $middlewareStorage;
        $this->configurator = $configurator;
        $this->configProvider = $configProvider;
        $this->config = $config;
    }

    public function build(): ConfiguratorInterface
    {
        $middlewares = $this->middlewareStorage->get($this->config['name']);

        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $this->configurator->addMiddleware($middleware);
        }

        $this->configurator->config['base_uri'] = $this->config['base_uri'];
        $this->configurator->config = $this->config['options'];

        $config = array_replace_recursive($this->configurator->config, $this->configProvider->getConfig());

        $this->configurator->config = $config;

        return $this->configurator;
    }
}