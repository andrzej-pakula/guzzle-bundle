<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Andreo\GuzzleBundle\RegistryInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class DataMapperLocator
{
    private ServiceLocator $dataMapperLocator;

    public function __construct(ServiceLocator $dataMapperLocator)
    {
        $this->dataMapperLocator = $dataMapperLocator;
    }

    public function get(string $format): DataMapperInterface
    {
        if ($this->dataMapperLocator->has($format)) {
            return $this->dataMapperLocator->get($format);
        }

        throw new RuntimeException("No data mapper found for format: $format");
    }
}