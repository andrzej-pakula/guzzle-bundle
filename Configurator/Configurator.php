<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Configurator;

use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use GuzzleHttp\HandlerStack;

final class Configurator implements ConfiguratorInterface
{
    private HandlerStack $handlerStack;

    /** @var array<string, mixed> */
    public array $config;

    /**
     * @param array<string, mixed> $config
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function __construct(array $config = [], iterable $middlewares = [])
    {
        $this->handlerStack = HandlerStack::create();
        $this->config = $config;

        /** @var MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }
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
        $this->config['handler'] = $this->handlerStack;

        return array_filter($this->config);
    }
}