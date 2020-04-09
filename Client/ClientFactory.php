<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;

class ClientFactory
{
    public function create(array $config): ClientInterface
    {
        return new Client($config);
    }
}