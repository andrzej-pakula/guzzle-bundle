<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Response;

use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Psr\Http\Message\ResponseInterface;

final class Response implements ResponseInterface
{
    use ResponseDecoratorTrait;

    private ?DTOInterface $dto;

    /** @var DTOInterface[]  */
    private ?array $dtos;

    public function withDTO(DTOInterface $dto): ResponseInterface
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

    public function getDTO(): ?DTOInterface
    {
        return $this->dto;
    }

    /**
     * @return DTOInterface[]
     */
    public function getDTOs(): ?array
    {
        return $this->dtos;
    }
}