<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Client;


use Andreo\GuzzleBundle\Client\ClientDecoratorTrait;
use Andreo\GuzzleBundle\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class FooClient implements ClientInterface
{
    use ClientDecoratorTrait;

    public function getFoo(): ResponseInterface
    {
        return $this->decorated->get('');
    }
}