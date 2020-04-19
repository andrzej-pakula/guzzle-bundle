<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

interface MiddlewareInterface
{
    public function __invoke(RequestInterface $request, array $options): PromiseInterface;

    public function apply(HandlerStack $stack): void;

    /**
     * @return string&ClientInterface
     */
    public function getClientName(): ?string;

    public function getNextHandler(): callable;

    public function withNextHandler(callable $handler): MiddlewareInterface;
}