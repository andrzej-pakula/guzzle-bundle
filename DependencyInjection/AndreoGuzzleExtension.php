<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\GuzzleBundle\Client\ClientFactoryInterface;
use Andreo\GuzzleBundle\Configurator\ConfigBuilder;
use Andreo\GuzzleBundle\Configurator\Configurator;
use Andreo\GuzzleBundle\Configurator\ConfiguratorFactoryInterface;
use Andreo\GuzzleBundle\Configurator\ConfigInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorInterface;
use Andreo\GuzzleBundle\Configurator\DelegatingConfigBuilder;
use Andreo\GuzzleBundle\Configurator\DelegatingConfiguration;
use Andreo\GuzzleBundle\Configurator\DelegatingConfiguratorInterface;
use Andreo\GuzzleBundle\DataTransfer\DataMapper;
use Andreo\GuzzleBundle\DataTransfer\DataMapperInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareStorageInterface;
use Andreo\GuzzleBundle\Middleware\ReverseTransferDataMiddleware;
use Andreo\GuzzleBundle\Middleware\TransferDataMiddleware;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorFactoryFactory;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\SerializerInterface;


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

            $configBuilderDef = (new Definition(DelegatingConfiguration::class))
                ->setPrivate(true)
                ->addArgument(new Reference(MiddlewareStorageInterface::class))
                ->addTag('andreo.guzzle.delegating_configurator')
                ->addArgument($clientConfig['decorator_id'] ?? $clientName)
                ->addArgument($clientConfig);

            $container->setDefinition(DelegatingConfiguration::class . '' . $clientName, $configBuilderDef);

            $clientDef = (new Definition(Client::class))
                ->setPrivate(true)
                ->setLazy($clientConfig['lazy'])
                ->setFactory([new Reference(ClientFactoryInterface::class), 'create'])
                ->addArgument(new Reference(Configurator::class));

            if (null !== $clientConfig['decorator_id']) {
                $clientDef->addTag('andreo.guzzle_decorated_client', [
                    'decorator_id' => $clientConfig['decorator_id']
                ]);
            }

            $container->setDefinition('andreo.guzzle_client.' . $clientName, $clientDef);

            if ($this->isConfigEnabled($container, $clientConfig['data_transfer'])) {
                $this->registerDataTransfer($clientConfig, $container);
            }
        }
    }

    private function registerDataTransfer(array $clientConfig, ContainerBuilder $container): void
    {
        $format = $clientConfig['data_transfer']['format'];

        $dataMapperId = DataMapperInterface::class . '.' . $format;

        if ($container->hasDefinition($dataMapperId)) {
            $dataMapperDef = $container->getDefinition($dataMapperId);
        } else {
            $dataMapperDef = (new Definition(DataMapper::class))
                ->setPrivate(true)
                ->addArgument(new Reference(SerializerInterface::class))
                ->addArgument($format);

            $container->setDefinition($dataMapperId, $dataMapperDef);
        }

        $transferDataMiddlewareId = TransferDataMiddleware::class . '.' . $format;
        if (!$container->hasDefinition($transferDataMiddlewareId)) {
            $transferDataMiddlewareDef = (new Definition(TransferDataMiddleware::class))
                ->setPrivate(true)
                ->addArgument($dataMapperDef)
                ->addTag('andreo.guzzle.middleware');

            $container->setDefinition($transferDataMiddlewareId, $transferDataMiddlewareDef);
        }

        $reverseTransferDataMiddlewareId = ReverseTransferDataMiddleware::class . '.' . $format;
        if (!$container->hasDefinition($reverseTransferDataMiddlewareId)) {
            $reverseTransferDataMiddlewareDef = (new Definition(ReverseTransferDataMiddleware::class))
                ->setPrivate(true)
                ->addArgument($dataMapperDef)
                ->addTag('andreo.guzzle.middleware');

            $container->setDefinition($reverseTransferDataMiddlewareId, $reverseTransferDataMiddlewareDef);
        }
    }

    private function registerForAutoconfiguration(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(MiddlewareInterface::class)
            ->addTag('andreo.guzzle.middleware');

        $container
            ->registerForAutoconfiguration(DelegatingConfiguratorInterface::class)
            ->addTag('andreo.guzzle.delegating_configurator');
    }
}
