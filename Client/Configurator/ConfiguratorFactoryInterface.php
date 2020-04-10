<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


interface ConfiguratorFactoryInterface
{
    public function create(ConfiguratorInterface $configurator): ConfiguratorInterface;
}