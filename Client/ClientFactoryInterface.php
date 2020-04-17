<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorInterface;
use Andreo\GuzzleBundle\Configurator\ConfigBuilderInterface;

interface ClientFactoryInterface
{
    public static function create(string $decoratorClass, ConfigBuilderInterface $builder, ConfiguratorInterface $configurator): ClientInterface;
}