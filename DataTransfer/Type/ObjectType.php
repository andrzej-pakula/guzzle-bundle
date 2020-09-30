<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer\Type;


final class ObjectType
{
    private const COLLECTION_TYPE = 'collection';
    private const SINGLE_TYPE = 'single';

    private string $type;
    private string $dataType;

    public function __construct(string $type, string $dataType)
    {
        $this->type = $type;
        $this->dataType = $dataType;
    }

    public static function single(string $type): self
    {
        return new self($type, self::SINGLE_TYPE);
    }

    public static function collection(string $type): self
    {
        return new self($type . '[]', self::COLLECTION_TYPE);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isCollection(): bool
    {
        return $this->dataType === self::COLLECTION_TYPE;
    }

    public function isSingle(): bool
    {
        return $this->dataType === self::SINGLE_TYPE;
    }
}
