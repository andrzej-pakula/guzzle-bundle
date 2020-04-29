<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;

use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use GuzzleHttp\HandlerStack;

final class Configurator implements ConfiguratorInterface
{
    /** @var iterable<DelegatingConfiguratorInterface>  */
    private iterable $delegatingConfigurators;

    private HandlerStack $handlerStack;

    /** @var array<string, mixed> */
    public array $config;

    public function __construct(iterable $delegatingConfigurators = [])
    {
        $this->handlerStack = HandlerStack::create();
        $this->delegatingConfigurators = $delegatingConfigurators;
    }

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $middleware->apply($this->handlerStack);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        /** @var DelegatingConfiguratorInterface $delegatingConfigurator */
        foreach ($this->delegatingConfigurators as $delegatingConfigurator) {
            $delegatingConfigurator->configure($this);
        }

        return array_filter($this->config);
    }
}