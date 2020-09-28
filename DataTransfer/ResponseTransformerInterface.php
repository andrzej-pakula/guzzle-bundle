<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function withDTO(string $type, ?DataTransferInterface $objectToPopulate = null): self;

    public function withDTOs(string $type): self;

    public function getResponse(): ResponseInterface;
}
