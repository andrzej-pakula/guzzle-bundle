<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


final class ConfiguratorFactory implements ConfiguratorFactoryInterface
{
    private array $config;

    /**
     * @param Configurator&ConfiguratorInterface $configurator
     */
    public function create(ConfiguratorInterface $configurator): ConfiguratorInterface
    {
        $configurator->baseURI = $this->config['base_uri'];

        return $configurator;
    }
}