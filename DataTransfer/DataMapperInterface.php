<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DataTransfer;

interface DataMapperInterface
{
    public function normalize(DTOInterface $data, array $options = []): array;

    public function serialize(DTOInterface $data, array $options = []): string;

    /**
     * @return DTOInterface|DTOInterface[]
     */
    public function deserialize(string $content, string $type, array $options = []);
}