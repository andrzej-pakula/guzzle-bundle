<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\HandlerStack;

interface MiddlewareInterface
{
    public function apply(HandlerStack $stack): void;
}