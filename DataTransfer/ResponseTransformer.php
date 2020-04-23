<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;

use Andreo\GuzzleBundle\Request\Response;
use Psr\Http\Message\ResponseInterface;

final class ResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @var Response&ResponseInterface
     */
    private Response $response;

    /**
     * @param Response&ResponseInterface $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response&ResponseInterface
     */
    public function withDTO(DataMapperInterface $dataMapper, DTOInterface $data): ResponseTransformerInterface
    {
        /** @var DTOInterface $dto */
        $dto = $dataMapper->deserialize($this->response->getBody()->getContents(), $data);

        return new self($this->response->withDTO($dto));
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}