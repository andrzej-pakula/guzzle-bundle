<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Andreo\GuzzleBundle\RegistryInterface;
use RuntimeException;

final class DataMapperRegistry
{
    /** @var iterable<DataMapperInterface> */
    private array $dataMappers;

    /**
     * @param iterable<DataMapperInterface> $dataMappers
     */
    public function __construct(iterable $dataMappers)
    {
        /** @var DataMapperInterface $dataMapper */
        foreach ($dataMappers as $dataMapper) {
            $this->dataMappers[$dataMapper->getFormat()] = $dataMapper;
        }
    }

    public function get(string $format): DataMapperInterface
    {
        if (array_key_exists($format, $this->dataMappers)) {
            return $this->dataMappers[$format];
        }

        throw new RuntimeException("No data mapper found for format: $format");
    }
}