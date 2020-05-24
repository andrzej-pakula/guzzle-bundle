<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;

interface DataMapperInterface
{
    public function normalize(DataTransferInterface $data, array $options = []): array;

    public function serialize(DataTransferInterface $data, array $options = []): string;

    /**
     * @return object|object[]
     */
    public function deserialize(string $content, string $type, array $options = []);
}