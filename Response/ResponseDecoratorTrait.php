<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Response;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

trait ResponseDecoratorTrait
{
    private ResponseInterface $decorated;

    public function __construct(ResponseInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function getProtocolVersion(): string
    {
        return $this->decorated->getProtocolVersion();
    }

    public function withProtocolVersion($version): MessageInterface
    {
        return $this->decorated->withProtocolVersion($version);
    }

    public function getHeaders(): array
    {
        return $this->decorated->getHeaders();
    }

    public function hasHeader($name): bool
    {
        return $this->decorated->hasHeader($name);
    }

    public function getHeader($name): array
    {
        return $this->decorated->getHeader($name);
    }

    public function getHeaderLine($name): string
    {
        return $this->decorated->getHeaderLine($name);
    }

    public function withHeader($name, $value): MessageInterface
    {
        return $this->decorated->withHeader($name, $value);
    }

    public function withAddedHeader($name, $value): MessageInterface
    {
        return $this->decorated->withAddedHeader($name, $value);
    }

    public function withoutHeader($name): MessageInterface
    {
        return $this->decorated->withoutHeader($name);
    }

    public function getBody(): StreamInterface
    {
        return $this->decorated->getBody();
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        return $this->decorated->withBody($body);
    }

    public function getStatusCode(): int
    {
        return $this->decorated->getStatusCode();
    }

    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
        return $this->decorated->withStatus($code, $reasonPhrase);
    }

    public function getReasonPhrase(): string
    {
        return $this->decorated->getReasonPhrase();
    }
}