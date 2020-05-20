<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class DataMapper implements DataMapperInterface
{
    /** @var Serializer&SerializerInterface  */
    private SerializerInterface $serializer;

    private string $format;

    public function __construct(SerializerInterface $serializer, string $format)
    {
        $this->serializer = $serializer;
        $this->format = $format;
    }

    public function normalize(DTOInterface $data, array $options = []): array
    {
        return $this->serializer->normalize($data, $this->format, $options);
    }

    public function serialize(DTOInterface $data, array $options = []): string
    {
        return $this->serializer->serialize($data, $this->format, $options);
    }

    public function deserialize(string $content, string $type, array $options = [])
    {
        return $this->serializer->deserialize($content, $type, $this->format, $options);
    }
}