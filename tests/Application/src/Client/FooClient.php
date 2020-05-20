<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Client;


use Andreo\GuzzleBundle\Client\ClientDecoratorTrait;
use Tests\Andreo\GuzzleBundle\App\Controller\GetDto;
use Tests\Andreo\GuzzleBundle\App\Controller\PostDto;
use GuzzleHttp\ClientInterface;

final class FooClient implements ClientInterface
{
    use ClientDecoratorTrait;
}