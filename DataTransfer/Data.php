<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Data implements DTOInterface
{
    public function transfer(RequestInterface $request, RequestTransformerInterface $transformer): RequestInterface
    {
        return $transformer->withBody($request, $this);
    }

    public function reverseTransfer(ResponseInterface $response, ResponseTransformerInterface $transformer): ResponseInterface
    {
        return $transformer->withDTO($response, $this);
    }
}