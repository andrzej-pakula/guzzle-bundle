<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Andreo\GuzzleBundle\DataTransfer\Type\ObjectType;
use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function withView(ObjectType $type, ?DataTransferInterface $objectToPopulate = null): self;

    public function getResponse(): ResponseInterface;
}
