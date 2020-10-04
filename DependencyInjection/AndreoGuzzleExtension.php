<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\GuzzleBundle\Client\ClientFactoryInterface;
use Andreo\GuzzleBundle\Configurator\Configurator;
use Andreo\GuzzleBundle\Configurator\ConfiguratorFactoryInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;


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
            $configuratorDef = new Definition(Configurator::class);
            if (null === $clientConfig['config_provider_id']) {
                $configuratorDef->setFactory([new Reference(ConfiguratorFactoryInterface::class), 'create']);
            } else {
                $configuratorFactory = (new Definition(ConfiguratorFactoryInterface::class))
                    ->setFactory([new Reference(ConfiguratorFactoryInterface::class), 'withConfigProvider'])
                    ->addArgument(new Reference($clientConfig['config_provider_id']));

                $configuratorDef->setFactory([$configuratorFactory, 'create']);
            }

            $decoratorId = $clientConfig['decorator_id'];
            $configuratorDef->setArguments([
                (null !== $decoratorId && class_exists($decoratorId)) ? $decoratorId : $clientName,
                $clientConfig
            ]);

            $clientDef = (new Definition(ClientInterface::class))
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
    }
}
