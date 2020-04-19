<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Client;


use Andreo\GuzzleBundle\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class FooClient implements ClientInterface
{
    private ClientInterface $decorated;

    /**
     * @param ClientInterface $decorated
     */
    public function __construct(ClientInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function getTodo()
    {
        return $this->get('/todos/1');
    }

    public function get(string $url): ResponseInterface
    {
        return $this->decorated->get($url);
    }

    public function post(string $url): ResponseInterface
    {
        return $this->decorated->post($url);
    }

    public function path(string $url): ResponseInterface
    {
        return $this->decorated->path($url);
    }

    public function put(string $url): ResponseInterface
    {
        return $this->decorated->put($url);
    }

    public function delete(string $url): ResponseInterface
    {
        return $this->decorated->delete($url);
    }
}