<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;

use Andreo\GuzzleBundle\Response\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

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
    public function withDTO(string $type, ?DataTransferInterface $objectToPopulate = null): ResponseTransformerInterface
    {
        $options = [];
        if (null !== $objectToPopulate) {
            $options[AbstractNormalizer::OBJECT_TO_POPULATE] = $objectToPopulate;
        }

        $dto = $this->dataMapper->deserialize($this->response->getBody()->getContents(), $type, $options);

        return new self($this->response->withDTO($dto), $this->dataMapper);
    }

    public function withDTOs(string $type): ResponseTransformerInterface
    {
        $dto = $this->dataMapper->deserialize($this->response->getBody()->getContents(), $type . '[]');

        return new self($this->response->withDTOs($dto), $this->dataMapper);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
