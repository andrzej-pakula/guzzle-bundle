<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


final class NullConfigProvider implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return [];
    }
}