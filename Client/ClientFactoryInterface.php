<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Configurator\ConfigInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorInterface;
use GuzzleHttp\ClientInterface;

interface ClientFactoryInterface
{
    public function create(string $decoratorClass, ConfiguratorInterface $configBuilder): ClientInterface;
}