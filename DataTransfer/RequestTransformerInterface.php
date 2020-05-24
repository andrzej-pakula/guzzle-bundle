<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;

interface RequestTransformerInterface
{
    public function withBody(DataTransferInterface $data): self;

    public function withQuery(DataTransferInterface $data): self;

    public function getRequest(): RequestInterface;
}