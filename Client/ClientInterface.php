<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;


use GuzzleHttp\ClientInterface as BaseClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface extends BaseClientInterface
{
    public function get(string $url, array $options = []): ResponseInterface;

    public function post(string $url, array $options = []): ResponseInterface;

    public function put(string $url, array $options = []): ResponseInterface;

    public function path(string $url, array $options = []): ResponseInterface;

    public function delete(string $url, array $options = []): ResponseInterface;

    public function getAsync(string $url, array $options = []): PromiseInterface;

    public function postAsync(string $url, array $options = []): PromiseInterface;

    public function putAsync(string $url, array $options = []): PromiseInterface;

    public function pathAsync(string $url, array $options = []): PromiseInterface;

    public function deleteAsync(string $url, array $options = []): PromiseInterface;
}