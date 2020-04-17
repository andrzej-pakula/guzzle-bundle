<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

final class Client implements ClientInterface
{
    private GuzzleClient $guzzle;

    public function __construct(GuzzleClient $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function post(string $url): ResponseInterface
    {
        return $this->guzzle->request(Request::METHOD_POST, $url);
    }

    public function get(string $url): ResponseInterface
    {
        return $this->guzzle->request(Request::METHOD_GET, $url);
    }

    public function path(string $url): ResponseInterface
    {
        return $this->guzzle->request(Request::METHOD_PATCH, $url);
    }

    public function put(string $url): ResponseInterface
    {
        return $this->guzzle->request(Request::METHOD_PUT, $url);
    }

    public function delete(string $url): ResponseInterface
    {
        return $this->guzzle->request(Request::METHOD_DELETE, $url);
    }
}