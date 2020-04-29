<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;

use Andreo\GuzzleBundle\Response\Response;
use Psr\Http\Message\ResponseInterface;

final class ResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @var Response&ResponseInterface
     */
    private Response $response;

    private DataMapperInterface $dataMapper;

    /**
     * @param Response&ResponseInterface $response
     */
    public function __construct(Response $response, DataMapperInterface $dataMapper)
    {
        $this->response = $response;
        $this->dataMapper = $dataMapper;
    }

    /**
     * @return Response&ResponseInterface
     */
    public function withDTO(DTOInterface $data): ResponseTransformerInterface
    {
        $dto = $this->dataMapper->deserialize($this->response->getBody()->getContents(), $data);

        return new self($this->response->withDTO($dto), $this->dataMapper);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}