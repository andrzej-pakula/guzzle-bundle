<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;


use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function get(string $url): ResponseInterface;

    public function post(string $url): ResponseInterface;

    public function path(string $url): ResponseInterface;

    public function put(string $url): ResponseInterface;

    public function delete(string $url): ResponseInterface;
}