<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


interface ConfiguratorFactoryInterface
{
    public function create(string $clientName, array $configuration): ConfiguratorInterface;
}