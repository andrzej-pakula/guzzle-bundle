<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Andreo\GuzzleBundle\DataTransfer\DataMapperLocator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Tests\Andreo\GuzzleBundle\App\Client\FooClient;

class TestController extends AbstractController
{
    /**
     * @Route("/test")
     */
    public function test(FooClient $fooClient, DataMapperLocator $dataMapperLocator)
    {
        dump($fooClient); die;
    }
}