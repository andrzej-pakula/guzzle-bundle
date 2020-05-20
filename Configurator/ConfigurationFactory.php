<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareSupportsInterface;
use Generator;

final class ConfigurationFactory implements ConfiguratorFactoryInterface
{
    /** @var iterable<MiddlewareInterface>  */
    private iterable $middlewares;

    private ?ConfigProviderInterface $configProvider;

    public function __construct(
        iterable $middlewares,
        ?ConfigProviderInterface $configProvider = null
    ) {
        $this->middlewares = $middlewares;
        $this->configProvider = $configProvider;
    }

    /**
     * @param array<string, mixed> $configuration
     */
    public function __invoke(string $clientName, array $configuration): ConfiguratorInterface
    {
        $config = $configuration['options'];
        $config['base_uri'] = $configuration['base_uri'];

        if (null !== $this->configProvider) {
            $config = array_replace_recursive($config, $this->configProvider->getConfig());
        }

        return new Configurator($config, $this->getSupportedMiddlewares($clientName, $config));
    }

    /**
     * @return Generator<MiddlewareInterface>
     */
    private function getSupportedMiddlewares(string $clientName, array $config): Generator
    {
        /** @var MiddlewareInterface $middleware */
        foreach ($this->middlewares as $middleware) {
            if ($middleware instanceof MiddlewareSupportsInterface && $middleware->supports($clientName, $config)) {
                yield $middleware;
            } else {
                yield $middleware;
            }
        }
    }

    public function withConfigProvider(ConfigProviderInterface $configProvider): self
    {
        return new self($this->middlewares, $configProvider);
    }
}