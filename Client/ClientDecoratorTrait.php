<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Response\RequestFactory;
use Andreo\GuzzleBundle\Response\Response;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Andreo\GuzzleBundle\Request\Methods;
use GuzzleHttp\ClientInterface;

trait ClientDecoratorTrait
{
    private ClientInterface $decorated;

    public function __construct(ClientInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->request(Methods::METHOD_GET, $url, $options);
    }

    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->request(Methods::METHOD_POST, $url, $options);
    }

    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->request(Methods::METHOD_PUT, $url, $options);
    }

    public function path(string $url, array $options = []): ResponseInterface
    {
        return $this->request(Methods::METHOD_PATCH, $url, $options);
    }

    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request(Methods::METHOD_DELETE, $url, $options);
    }

    public function getAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(Methods::METHOD_GET, $url, $options);
    }

    public function postAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(Methods::METHOD_POST, $url, $options);
    }

    public function putAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(Methods::METHOD_PUT, $url, $options);
    }

    public function pathAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(Methods::METHOD_PATCH, $url, $options);
    }

    public function deleteAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(Methods::METHOD_DELETE, $url, $options);
    }

    /**
     * @return Response&ResponseInterface
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->decorated->send($request, $options);
    }

    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->decorated->sendAsync($request, $options);
    }

    /**
     * @return Response&ResponseInterface
     */
    public function request($method, $uri, array $options = []): ResponseInterface
    {
        return $this->decorated->request($method, $uri, $options);
    }

    public function requestAsync($method, $uri, array $options = []): PromiseInterface
    {
        return $this->decorated->requestAsync($method, $uri, $options);
    }

    /**
     * @return array|mixed|null
     */
    public function getConfig($option = null)
    {
        return $this->decorated->getConfig($option);
    }
}