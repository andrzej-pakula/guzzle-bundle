<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

interface MiddlewareInterface
{
    public function __invoke(RequestInterface $request, array $options): void;

    public function apply(HandlerStack $stack): void;

    /**
     * @return string&ClientInterface
     */
    public function getClientName(): ?string;

    public function getNextHandler(): MiddlewareHandler;

    public function withNextHandler(MiddlewareHandler $handler): MiddlewareInterface;
}