<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client\Configurator;

use Andreo\GuzzleBundle\Client\ClientInterface;
use Andreo\GuzzleBundle\Middleware\MiddlewareInterface;
use GuzzleHttp\HandlerStack;

final class Configurator implements ConfiguratorInterface
{
    public ?string $baseURI;

    public ?string $timeout;

    public ?bool $allowRedirects;

    /** @var string&ClientInterface */
    public ?string $decoratorClass;

    private HandlerStack $handlerStack;

    /**
     * @param iterable<MiddlewareInterface> $middlewares
     */
    public function __construct()
    {
        $this->handlerStack = HandlerStack::create();
    }

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $middleware->apply($this->handlerStack);
    }

    /**
     * @return string&ClientInterface
     */
    public function getDecoratorClass(): ?string
    {
        return $this->decoratorClass;
    }

    public function getConfig(): array
    {
        $options['base_uri'] = $this->baseURI;
        $options['timeout'] = 10;
        $options['allow_redirects'] = $this->allowRedirects;
        $options['handler'] = $this->handlerStack;

        return array_filter($options);
    }
}