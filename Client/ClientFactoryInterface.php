<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Client;

use GuzzleHttp\ClientInterface;

interface ClientFactoryInterface
{
    public function create(ClientBuilderInterface $builder): ClientInterface;
}