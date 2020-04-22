<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;

interface DataMapperInterface
{
    public function normalize(DTOInterface $data): array;

    public function serialize(DTOInterface $data): string;

    public function deserialize(string $content, DTOInterface $data): string;
}