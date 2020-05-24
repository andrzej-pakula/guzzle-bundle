<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Response;

use Andreo\GuzzleBundle\DataTransfer\DataTransferInterface;
use Psr\Http\Message\ResponseInterface;

final class Response implements ResponseInterface
{
    use ResponseDecoratorTrait;

    private ?object $dto;

    /** @var DataTransferInterface[]  */
    private ?array $dtos;

    public function withDTO(object $dto): ResponseInterface
    {
        $new = clone $this;
        $new->dto = $dto;

        return $new;
    }

    public function withDTOs(array $dtos): ResponseInterface
    {
        $new = clone $this;
        $new->dtos = $dtos;

        return $new;
    }

    public function getDTO(): ?object
    {
        return $this->dto;
    }

    /**
     * @return object[]
     */
    public function getDTOs(): ?array
    {
        return $this->dtos;
    }
}