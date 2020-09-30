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
    private $view;

    /**
     * @param mixed $view
     */
    public function withView($view): ResponseInterface
    {
        $new = clone $this;
        $new->view = $view;

        return $new;
    }

    public function getView()
    {
        return $this->view;
    }
}
