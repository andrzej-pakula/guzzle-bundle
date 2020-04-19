<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Andreo\GuzzleBundle\Client\ClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Tests\Andreo\GuzzleBundle\App\Client\FooClient;

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
    public function index()
    {
        dump($this->fooClient);
        dump($this->barClient); die;
    }
}