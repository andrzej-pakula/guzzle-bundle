<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


interface DelegatingConfiguratorInterface
{
    public function configure(ConfiguratorInterface $configurator): void;
}