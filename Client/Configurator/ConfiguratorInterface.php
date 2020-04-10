<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


interface ConfiguratorInterface
{
    public function getConfig(): array;

    public function getDecorator(): string;
}