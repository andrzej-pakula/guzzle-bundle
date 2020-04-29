<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;

interface DataMapperInterface
{
    public function normalize(DTOInterface $data, array $options = []): array;

    public function serialize(DTOInterface $data, array $options = []): string;

    public function deserialize(string $content, DTOInterface $data, array $options = []): DTOInterface;

    public function getFormat(): string;
}