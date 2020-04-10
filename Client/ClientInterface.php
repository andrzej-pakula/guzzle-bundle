<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Client;


use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function post(string $url): void;
    public function get(string $url): ResponseInterface;
}