<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DataTransfer;


use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

final class RequestTransformer implements RequestTransformerInterface
{
    private DataMapperInterface $dataMapper;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function withBody(RequestInterface $request, DTOInterface $data): RequestInterface
    {
        $stream = stream_for($this->dataMapper->serialize($data));

        return $request->withBody($stream);
    }

    public function withQuery(RequestInterface $request, DTOInterface $data): RequestInterface
    {
        $query = http_build_query($this->dataMapper->normalize($data));

        return $request->withUri($request->getUri()->withQuery($query));
    }
}