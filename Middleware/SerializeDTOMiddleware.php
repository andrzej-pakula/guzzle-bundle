<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

final class SerializeDTOMiddleware implements MiddlewareInterface
{
    use MiddlewareTrait;

    public function __invoke(RequestInterface $request, array $options): void
    {
        $nextHandler = $this->getNextHandler();
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->push($this, self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }

}