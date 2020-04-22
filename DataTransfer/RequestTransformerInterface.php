<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;

interface RequestTransformerInterface
{
    public function withBody(RequestInterface $request, DTOInterface $data): RequestInterface;

    public function withQuery(RequestInterface $request, DTOInterface $data): RequestInterface;
}