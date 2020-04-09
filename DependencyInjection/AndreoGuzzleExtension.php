<?php

declare(strict_types=1);

namespace Andreo\OAuthApiConnectorBundle\DependencyInjection;

use Andreo\Component\Messaging\Configurator\ConfiguratorFactoryFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class AndreoGuzzleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
    }

    private function registerConfiguration(ContainerBuilder $container, array $clientsConfigs): void
    {
    }
}
