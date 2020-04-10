<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorFactoryInterface;
use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorInterface;

final class DefaultClientBuilder implements ClientBuilderInterface
{
    private ConfiguratorFactoryInterface $configuratorFactory;

    public function __construct(ConfiguratorFactoryInterface $configuratorFactory)
    {
        $this->configuratorFactory = $configuratorFactory;
    }

    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface
    {
        return $this->configuratorFactory->create($configurator);
    }
}