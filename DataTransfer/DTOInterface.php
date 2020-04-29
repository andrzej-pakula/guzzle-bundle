<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;


interface DTOInterface
{
    public function transfer(RequestTransformerInterface $transformer): RequestTransformerInterface;

    public function reverseTransfer(ResponseTransformerInterface $transformer): ResponseTransformerInterface;
}