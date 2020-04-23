<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function withDTO(DataMapperInterface $dataMapper, DTOInterface $data): self;

    public function getResponse(): ResponseInterface;
}