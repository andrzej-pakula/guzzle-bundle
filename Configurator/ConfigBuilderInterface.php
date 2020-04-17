<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Configurator;

use Andreo\GuzzleBundle\Configurator\ConfiguratorInterface;

interface ConfigBuilderInterface
{
    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface;
}