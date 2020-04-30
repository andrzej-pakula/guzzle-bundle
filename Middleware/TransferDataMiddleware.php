<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Client\ClientOptions;
use Andreo\GuzzleBundle\DataTransfer\DataMapperRegistry;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\RequestTransformer;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class TransferDataMiddleware implements InvokableMiddlewareInterface, MiddlewareSupportsInterface
{
    use InvokableMiddlewareTrait;

    private DataMapperRegistry $dataMapperRegistry;

    public function __construct(DataMapperRegistry $dataMapperRegistry)
    {
        $this->dataMapperRegistry = $dataMapperRegistry;
    }

    /**
     * @param Request&RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        /** @var DTOInterface|null $dto */
        $dto = $options[ClientOptions::DTO] ??= null;

        if ($dto instanceof DTOInterface) {
            $dataMapper = $this->dataMapperRegistry->get($options[ClientOptions::DTO_SUPPORTS][ClientOptions::FORMAT]);
            $transformer = $dto->transfer(new RequestTransformer($request, $dataMapper));

            $request = $transformer->getRequest()
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('Accept', 'application/json');
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

    public function supports(array $config): bool
    {
        return !empty($config[ClientOptions::DTO_SUPPORTS]);
    }
}