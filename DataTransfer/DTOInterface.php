<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface DTOInterface
{
    public function transfer(RequestInterface $request, RequestTransformerInterface $transformer): RequestInterface;

    public function reverseTransfer(ResponseInterface $response, ResponseTransformerInterface $transformer): ResponseInterface;
}