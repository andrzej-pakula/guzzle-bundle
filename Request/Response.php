<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Request;

use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;

final class Response implements ResponseInterface
{
    use ResponseDecoratorTrait;

    private DTOInterface $dto;

    public function withDTO(DTOInterface $dto): MessageInterface
    {
        if ($dto === $this->dto) {
            return $this;
        }

        $new = clone $this;
        $new->dto = $dto;

        return $new;
    }
}