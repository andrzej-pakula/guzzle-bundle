<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


final class NullDelegatingConfigurator implements DelegatingConfiguratorInterface
{
    public function configure(ConfiguratorInterface $configurator): void
    {
    }
}