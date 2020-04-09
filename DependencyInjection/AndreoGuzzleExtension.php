<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\Component\Messaging\Configurator\ConfiguratorFactoryFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class AndreoGuzzleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
