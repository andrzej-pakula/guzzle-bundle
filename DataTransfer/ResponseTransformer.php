<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Andreo\GuzzleBundle\Request\Response;
use Psr\Http\Message\ResponseInterface;

final class ResponseTransformer implements ResponseTransformerInterface
{
    private DataMapperInterface $dataMapper;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param Response&ResponseInterface $response
     */
    public function withDTO(ResponseInterface $response, DTOInterface $data): ResponseInterface
    {
        /** @var DTOInterface $dto */
        $dto = $this->dataMapper->deserialize($response->getBody()->getContents(), $data);

        return $response->withDTO($dto);
    }
}