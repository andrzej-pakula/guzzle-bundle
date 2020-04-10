<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

final class DefaultClient implements ClientInterface
{
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function post(string $url): void
    {
        $this->guzzle->post($url);
    }

    public function get(string $url): ResponseInterface
    {
        return $this->guzzle->get($url);
    }
}