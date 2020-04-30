<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;


interface ConfigProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array;
}