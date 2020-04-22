<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function withDTO(ResponseInterface $response, DTOInterface $data): ResponseInterface;
}