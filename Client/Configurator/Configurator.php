<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;


class Configurator implements ConfiguratorInterface
{
    public string $baseURI;
    /** @var string&ClientInterface */
    public string $decorator = ClientInterface::class;

    public function getConfig(): array
    {
        $options['base_uri'] = $this->baseURI;
        $options['timeout'] = 10;

        return array_filter($options);
    }

    public function getDecorator(): string
    {
        return $this->decorator;
    }
}