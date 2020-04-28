<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\RequestOptions;
use Andreo\GuzzleBundle\DataTransfer\DataMapperInterface;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformer;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class TransferDataMiddleware implements InvokableMiddlewareInterface
{
    use InvokableMiddlewareTrait;

    private DataMapperInterface $dataMapper;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param Request&RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        /** @var DTOInterface|null $dto */
        $dto = $options[RequestOptions::DTO] ??= null;

        if (null !== $dto) {
            $transformer = $dto->transfer($this->dataMapper, new RequestTransformer($request));
            $request = $transformer->getRequest();
        }

        return $nextHandler($request, $options);
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->before('prepare_body', new InvokableMiddlewareHandler($this), self::class);
    }

    public function getClientName(): ?string
    {
        return null;
    }
}