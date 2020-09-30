<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Andreo\GuzzleBundle\DataTransfer\Type\DataType;
use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function withData(DataType $type, ?DataTransferInterface $objectToPopulate = null): self;

    public function getResponse(): ResponseInterface;
}
