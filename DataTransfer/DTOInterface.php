<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;


interface DTOInterface
{
    public function transfer(DataMapperInterface $dataMapper, RequestTransformerInterface $transformer): RequestTransformerInterface;

    public function reverseTransfer(DataMapperInterface $dataMapper, ResponseTransformerInterface $transformer): ResponseTransformerInterface;
}