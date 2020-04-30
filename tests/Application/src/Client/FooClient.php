<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Client;


use Andreo\GuzzleBundle\Client\ClientDecoratorTrait;
use Andreo\GuzzleBundle\Client\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Andreo\GuzzleBundle\App\Controller\GetDto;
use Tests\Andreo\GuzzleBundle\App\Controller\PostDto;

final class FooClient implements ClientInterface
{
    use ClientDecoratorTrait;

    public function getTodo(): ResponseInterface
    {
        return $this->get('/todos/1', [
            'dto' => new GetDto(),
        ]);
    }

    public function postPosts(): ResponseInterface
    {
        return $this->get('/posts', [
            'dto' => new PostDto(),
        ]);
    }

    public function getTodoAsync(): PromiseInterface
    {
        return $this->getAsync('/todos/1', [
            'dto' => new GetDto(),
        ]);
    }
}