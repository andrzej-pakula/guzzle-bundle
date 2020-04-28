<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

final class RequestTransformer implements RequestTransformerInterface
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function withBody(DataMapperInterface $dataMapper, DTOInterface $data): RequestTransformerInterface
    {
        $stream = stream_for($dataMapper->serialize($data));

        return new self($this->request->withBody($stream));
    }

    public function withQuery(DataMapperInterface $dataMapper, DTOInterface $data): RequestTransformerInterface
    {
        $query = http_build_query($dataMapper->normalize($data));
        $uri = $this->request->getUri()->withQuery($query);

        return new self($this->request->withUri($uri));
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}