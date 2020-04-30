<?php

declare(strict_types=1);


namespace Tests\Andreo\GuzzleBundle\App\Controller;


use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformerInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformerInterface;

class GetDto implements DTOInterface
{
    public int $userId;
    public int $id;
    public string $title;
    public bool $completed;

    public function __construct(int $userId = 1, int $id = 2, string $title = 'jazda', bool $completed = true)
    {
        $this->userId = $userId;
        $this->id = $id;
        $this->title = $title;
        $this->completed = $completed;
    }

    public function transfer(RequestTransformerInterface $transformer): RequestTransformerInterface
    {
        return $transformer->withQuery($this);
    }

    public function reverseTransfer(ResponseTransformerInterface $transformer): ResponseTransformerInterface
    {
        return $transformer->withDTO($this);
    }

    public function __toString(): string
    {
        return $this->title;
    }
}