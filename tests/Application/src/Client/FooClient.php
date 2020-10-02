<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Client;


use Andreo\GuzzleBundle\Client\ClientDecoratorTrait;
use GuzzleHttp\ClientInterface;

final class FooClient implements ClientInterface
{
    use ClientDecoratorTrait;
}
