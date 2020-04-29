<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareRegistryInterface;

final class ConfigurationFactory implements ConfiguratorFactoryInterface
{
    /** @var array<string, mixed> */
    private array $configuration;

    private string $clientName;

    private MiddlewareRegistryInterface $middlewareStorage;

    private ?ConfiguratorFactoryInterface $delegatingConfiguratorFactory;

    public function __construct(
        array $configuration,
        string $clientName,
        MiddlewareRegistryInterface $middlewareStorage,
        ?ConfiguratorFactoryInterface $delegatingConfiguratorFactory = null
    ) {
        $this->configuration = $configuration;
        $this->clientName = $clientName;
        $this->middlewareStorage = $middlewareStorage;
        $this->delegatingConfiguratorFactory = $delegatingConfiguratorFactory;
    }

    private function setMiddlewares(ConfiguratorInterface $configurator): void
    {
        $middlewares = $this->middlewareStorage->get($this->clientName);

        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            if ($middleware->supports($this->configuration['options'])) {
                $configurator->addMiddleware($middleware);
            }
        }
    }

    public function create(ConfiguratorInterface $configurator): ConfiguratorInterface
    {
        $this->setMiddlewares($configurator);

        $configurator->config = $this->configuration['options'];
        $configurator->config['base_uri'] = $this->configuration['base_uri'];

        if (null !== $this->delegatingConfiguratorFactory) {
            $this->delegatingConfiguratorFactory->create($configurator);
        }

        return $configurator;
    }
}