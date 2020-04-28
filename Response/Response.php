<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Response;

use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Psr\Http\Message\ResponseInterface;

final class Response implements ResponseInterface
{
    use ResponseDecoratorTrait;

    private ?DTOInterface $dto;

    public function withDTO(DTOInterface $dto): ResponseInterface
    {
        if ($dto === $this->dto) {
            return $this;
        }

        $new = clone $this;
        $new->dto = $dto;

        return $new;
    }

    public function getDTO(): ?DTOInterface
    {
        return $this->dto;
    }
}