<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


final class DelegatingConfigBuilder implements DelegatingConfigBuilderInterface
{
    /** @var array<string, mixed> */
    private array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Configurator&ConfiguratorInterface $configurator
     */
    public function build(ConfiguratorInterface $configurator): ConfiguratorInterface
    {
        $configurator->baseURI = $this->config['base_uri'];
        $configurator->timeout = $this->config['timeout'];
        $configurator->decoratorClass = $this->config['decorator_id'];

        return $configurator;
    }
}