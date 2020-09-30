<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle\Response;

use Psr\Http\Message\ResponseInterface;

final class Response implements ResponseInterface
{
    use ResponseDecoratorTrait;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param mixed $data
     */
    public function withData($data): ResponseInterface
    {
        $new = clone $this;
        $new->data = $data;

        return $new;
    }

    public function getData()
    {
        return $this->data;
    }
}
