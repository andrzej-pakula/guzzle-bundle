<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

interface MiddlewareInterface
{
    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface;

    public function withNext(callable $handler): MiddlewareInterface;

    public function join(HandlerStack $stack);
}
