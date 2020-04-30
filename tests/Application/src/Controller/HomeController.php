<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tests\Andreo\GuzzleBundle\App\Client\FooClient;
use GuzzleHttp\ClientInterface;

class HomeController extends AbstractController
{
    private FooClient $fooClient;
    private ClientInterface $barClient;

    public function __construct(FooClient $fooClient, ClientInterface $barClient)
    {
        $this->fooClient = $fooClient;
        $this->barClient = $barClient;
    }

    /**
     * @Route("/home")
     */
    public function index(FooClient $fooClient, LoggerInterface $logger): Response
    {
        $response = $fooClient->postPosts();

        dump($response); die;

        return new Response('ok');
    }
}