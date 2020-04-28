<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;

use Andreo\GuzzleBundle\Response\RequestFactory;
use Andreo\GuzzleBundle\Response\Response;
use GuzzleHttp\ClientInterface as BaseClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait ClientDecoratorTrait
{
    /**
     * @var BaseClientInterface
     */
    private BaseClientInterface $decorated;

    public function __construct(BaseClientInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->request(RequestMethods::METHOD_GET, $url, $options);
    }

    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->request(RequestMethods::METHOD_POST, $url, $options);
    }

    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->request(RequestMethods::METHOD_PUT, $url, $options);
    }

    public function path(string $url, array $options = []): ResponseInterface
    {
        return $this->request(RequestMethods::METHOD_PATCH, $url, $options);
    }

    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request(RequestMethods::METHOD_DELETE, $url, $options);
    }

    public function getAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(RequestMethods::METHOD_GET, $url, $options);
    }

    public function postAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(RequestMethods::METHOD_POST, $url, $options);
    }

    public function putAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(RequestMethods::METHOD_PUT, $url, $options);
    }

    public function pathAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(RequestMethods::METHOD_PATCH, $url, $options);
    }

    public function deleteAsync(string $url, array $options = []): PromiseInterface
    {
        return $this->requestAsync(RequestMethods::METHOD_DELETE, $url, $options);
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