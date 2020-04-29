<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(FooClient $fooClient): JsonResponse
    {

        dump($fooClient); die;

        dump((string)$response->getBody()); die;
    }
}