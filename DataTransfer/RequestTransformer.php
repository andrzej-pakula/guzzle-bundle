<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

final class RequestTransformer implements RequestTransformerInterface
{
    private RequestInterface $request;

    private DataMapperInterface $dataMapper;

    public function __construct(RequestInterface $request, DataMapperInterface $dataMapper)
    {
        $this->request = $request;
        $this->dataMapper = $dataMapper;
    }

    public function withBody(DataTransferInterface $data): RequestTransformerInterface
    {
        $stream = stream_for($this->dataMapper->serialize($data));

        $new = clone $this;
        $new->request = $this->request->withBody($stream);

        return $new;
    }

    public function withQuery(DataTransferInterface $data): RequestTransformerInterface
    {
        $query = http_build_query($this->dataMapper->normalize($data));
        $uri = $this->request->getUri()->withQuery($query);

        $new = clone $this;
        $new->request = $this->request->withUri($uri);

        return $new;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
