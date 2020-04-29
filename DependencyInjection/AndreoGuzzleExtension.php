<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\GuzzleBundle\Client\ClientFactoryInterface;
use Andreo\GuzzleBundle\Configurator\ConfigBuilder;
use Andreo\GuzzleBundle\Configurator\Configurator;
use Andreo\GuzzleBundle\Configurator\ConfigInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorInterface;
use Andreo\GuzzleBundle\Configurator\DelegatingConfigBuilder;
use Andreo\GuzzleBundle\Configurator\ConfigurationFactory;
use Andreo\GuzzleBundle\DataTransfer\DataMapperInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareRegistryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorFactoryFactory;
use GuzzleHttp\Client;


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

            $configBuilderDef = (new Definition(ConfigurationFactory::class))
                ->setPrivate(true)
                ->addArgument($clientConfig)
                ->addArgument($clientConfig['decorator_id'] ?? $clientName)
                ->addArgument(new Reference(MiddlewareRegistryInterface::class));

            if (null !== $clientConfig['configurator_factory_id']) {
                $configBuilderDef->addArgument(new Reference($clientConfig['configurator_factory_id']));
            }

            $configuratorDef = (new Definition(Configurator::class))
                ->setFactory([$configBuilderDef, 'create'])
                ->addArgument(new Reference(ConfiguratorInterface::class));

            $clientDef = (new Definition(Client::class))
                ->setPrivate(true)
                ->setLazy($clientConfig['lazy'])
                ->setFactory([new Reference(ClientFactoryInterface::class), 'create'])
                ->addArgument($configuratorDef);

            if (null !== $clientConfig['decorator_id']) {
                $clientDef->addTag('andreo.guzzle_decorated_client', [
                    'decorator_id' => $clientConfig['decorator_id']
                ]);
            }

            $container->setDefinition('andreo.guzzle_client.' . $clientName, $clientDef);
        }
    }

    private function registerForAutoconfiguration(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(MiddlewareInterface::class)
            ->addTag('andreo.guzzle.middleware');

        $container
            ->registerForAutoconfiguration(DataMapperInterface::class)
            ->addTag('andreo.guzzle.data_mapper');
    }
}
