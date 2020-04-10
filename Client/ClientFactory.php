<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Client\Configurator\Configurator;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;

class ClientFactory implements ClientFactoryInterface
{
    public function create(ClientBuilderInterface $builder): ClientInterface
    {
        $configurator = $builder->build(new Configurator());

        $decorator = $configurator->getDecorator();

        return new $decorator(new Client($configurator->getConfig()));
    }
}