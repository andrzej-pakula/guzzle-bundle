<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;

interface RequestTransformerInterface
{
    public function withBody(DTOInterface $data): self;

    public function withQuery(DTOInterface $data): self;

    public function getRequest(): RequestInterface;
}