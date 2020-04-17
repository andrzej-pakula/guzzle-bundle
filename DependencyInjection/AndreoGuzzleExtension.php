<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\GuzzleBundle\Client\Client;
use Andreo\GuzzleBundle\Client\ClientFactoryInterface;
use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorFactoryInterface;
use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorInterface;
use Andreo\GuzzleBundle\Client\Configurator\DelegatingConfigBuilder;
use Andreo\GuzzleBundle\Client\Configurator\DelegatingConfigBuilderInterface;
use Andreo\GuzzleBundle\Configurator\ConfigBuilder;
use Andreo\GuzzleBundle\Configurator\ConfigBuilderInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareStorageInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorFactoryFactory;


class AndreoGuzzleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $this->registerClientConfig($config['clients'] ?? [], $container);

        $this->registerForAutoconfiguration($container);

    }

    private function registerClientConfig(array $clients, ContainerBuilder $container): void
    {
        /** @var array<string, mixed> $clientConfig */
        foreach ($clients as $clientName => $clientConfig) {

            $delegatingConfigBuilderDef = (new Definition(DelegatingConfigBuilder::class))
                ->setPrivate(true)
                ->addArgument($clientConfig);

            $container->setDefinition(DelegatingConfigBuilderInterface::class . '.' . $clientName, $delegatingConfigBuilderDef);

            $configBuilderDef = (new Definition(ConfigBuilder::class))
                ->setPrivate(true)
                ->addArgument($clientName)
                ->addArgument($delegatingConfigBuilderDef)
                ->addArgument(new Reference(MiddlewareStorageInterface::class));

            $container->setDefinition(ConfigBuilderInterface::class . '.' . $clientName, $configBuilderDef);

            $clientDef = (new Definition(Client::class))
                ->setPrivate(true)
                ->setFactory([new Reference(ClientFactoryInterface::class), 'create'])
                ->addArgument(Client::class)
                ->addArgument($configBuilderDef)
                ->addArgument(new Reference(ConfiguratorInterface::class));

            $clientId = 'andreo.guzzle_client.' . $clientName;

            $container->setDefinition($clientId, $clientDef);

            if (null !== $clientConfig['decorator_id'] && !$container->has($clientConfig['decorator_id'])) {
                $clientDecoratorDef = (new Definition(Client::class))
                    ->setPrivate(true)
                    ->setDecoratedService($clientId)
                    ->addArgument($clientConfig['decorator_id'] . '.inner');

                $container->setDefinition($clientConfig['decorator_id'], $clientDecoratorDef);
            }
        }
    }

    private function registerForAutoconfiguration(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(MiddlewareInterface::class)
            ->addTag('andreo.guzzle.middleware');
    }
}
