<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareRegistryInterface;

final class ConfigurationFactory implements ConfiguratorFactoryInterface
{
    /** @var array<string, mixed> */
    private array $configuration;

    private string $clientName;

    private MiddlewareRegistryInterface $middlewareStorage;

    private ?ConfigProviderInterface $configProvider;

    public function __construct(
        array $configuration,
        string $clientName,
        MiddlewareRegistryInterface $middlewareStorage,
        ?ConfigProviderInterface $configProvider = null
    ) {
        $this->configuration = $configuration;
        $this->clientName = $clientName;
        $this->middlewareStorage = $middlewareStorage;
        $this->configProvider = $configProvider;
    }

    public function create(): ConfiguratorInterface
    {
        $middlewares = $this->middlewareStorage->get($this->clientName);

        $config = $this->configuration['options'];
        $config['base_uri'] = $this->configuration['base_uri'];

        if (null !== $this->configProvider) {
            $config = array_replace_recursive($config, $this->configProvider->getConfig());
        }

        return new Configurator($config, $middlewares);
    }
}