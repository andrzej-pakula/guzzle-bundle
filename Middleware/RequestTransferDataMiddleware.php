<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Request\Options;
use Andreo\GuzzleBundle\DataTransfer\DataMapperLocator;
use Andreo\GuzzleBundle\DataTransfer\DataTransferInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformer;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class RequestTransferDataMiddleware implements MiddlewareInterface, MiddlewareSupportsInterface
{
    use MiddlewareTrait;

    private DataMapperLocator $dataMapperLocator;

    public function __construct(DataMapperLocator $dataMapperLocator)
    {
        $this->dataMapperLocator = $dataMapperLocator;
    }

    /**
     * @param Request&RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->next;

        /** @var DataTransferInterface|null $dto */
        $dto = $options[Options::DTO] ??= null;

        if ($dto instanceof DataTransferInterface) {
            $dataMapper = $this->dataMapperLocator->get($options[Options::DATA_TRANSFER][Options::FORMAT]);
            $transformer = $dto->transfer(new RequestTransformer($request, $dataMapper));

            $request = $transformer->getRequest()
                ->withHeader('Content-DataType', 'application/json')
                ->withHeader('Accept', 'application/json');
        }

        return $nextHandler($request, $options);
    }

    public function join(HandlerStack $stack): void
    {
        $stack->before('prepare_body', new MiddlewareHandler($this), self::class);
    }

    public function supports(string $clientName, array $options): bool
    {
        return $options[Options::DATA_TRANSFER]['enabled'];
    }
}
