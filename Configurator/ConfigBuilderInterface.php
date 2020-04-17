<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Configurator;

interface ConfigBuilderInterface
{
    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface;
}