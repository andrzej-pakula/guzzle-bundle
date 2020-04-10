<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Client\Configurator\ConfiguratorInterface;

interface ClientBuilderInterface
{
    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface;
}