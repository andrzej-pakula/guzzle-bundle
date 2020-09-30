<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;

use Andreo\GuzzleBundle\DataTransfer\Type\DataType;
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
    public function withData(DataType $type, ?DataTransferInterface $objectToPopulate = null): ResponseTransformerInterface
    {
        $options = [];
        if (null !== $objectToPopulate) {
            $options[AbstractNormalizer::OBJECT_TO_POPULATE] = $objectToPopulate;
        }

        $data = $this->dataMapper->deserialize($this->response->getBody()->getContents(), $type->getType(), $options);

        $new = clone $this;
        $new->response = $this->response->withData($data);

        return $new;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
