<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

interface InvokableMiddlewareInterface extends MiddlewareInterface
{
    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface;

    public function getNextHandler(): callable;

    public function withNextHandler(callable $handler): InvokableMiddlewareInterface;
}