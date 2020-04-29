<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformerInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformerInterface;

class Dto implements DTOInterface
{
    public int $userId;
    public int $id;
    public string $title;
    public bool $completed;

    public function transfer(RequestTransformerInterface $transformer): RequestTransformerInterface
    {
        return $transformer;
    }

    public function reverseTransfer(ResponseTransformerInterface $transformer): ResponseTransformerInterface
    {
        return $transformer->withDTO($this);
    }
}