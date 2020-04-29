<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Configurator\ConfigInterface;
use Andreo\GuzzleBundle\Configurator\ConfiguratorInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;

final class ClientFactory implements ClientFactoryInterface
{
    public function create(ConfiguratorInterface $configurator): ClientInterface
    {
        return new GuzzleClient($configurator->getConfig());
    }
}