<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorInterface;
use GuzzleHttp\Client as GuzzleClient;
use Andreo\GuzzleBundle\Configurator\ConfigBuilderInterface;

final class ClientFactory implements ClientFactoryInterface
{
    public static function create(string $decoratorClass, ConfigBuilderInterface $builder, ConfiguratorInterface $configurator): ClientInterface
    {
        $configurator = $builder->build($configurator);

        return new $decoratorClass(
            new GuzzleClient($configurator->getConfig())
        );
    }
}