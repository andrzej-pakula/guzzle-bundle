<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\Middleware;

use Andreo\GuzzleBundle\Request\Options;
use Andreo\GuzzleBundle\DataTransfer\DataMapperLocator;
use Andreo\GuzzleBundle\DataTransfer\DTOInterface;
use Andreo\GuzzleBundle\DataTransfer\ResponseTransformer;
use Andreo\GuzzleBundle\Response\Response;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

final class ReverseTransferDataMiddleware implements InvokableMiddlewareInterface, MiddlewareSupportsInterface
{
    use InvokableMiddlewareTrait;

    private DataMapperLocator $dataMapperLocator;

    public function __construct(DataMapperLocator $dataMapperLocator)
    {
        $this->dataMapperLocator = $dataMapperLocator;
    }

    /**
     * @param RequestInterface&MessageInterface $request
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $nextHandler = $this->getNextHandler();

        return $nextHandler($request, $options)->then(
            function (ResponseInterface $response) use ($request, $options) {
                /** @var DTOInterface|null $dto */
                $dto = $options[Options::DTO] ??= null;

                if ($dto instanceof DTOInterface) {
                    $dataMapper = $this->dataMapperLocator->get($options[Options::DTO_SUPPORTS][Options::FORMAT]);
                    $transformer = $dto->reverseTransfer(new ResponseTransformer(new Response($response), $dataMapper));
                    $response = $transformer->getResponse();
                }

                return $response;
            }
        );
    }

    public function apply(HandlerStack $stack): void
    {
        $stack->unshift(new InvokableMiddlewareHandler($this), self::class);
    }

    public function supports(string $clientName, array $options): bool
    {
        return $options[Options::DTO_SUPPORTS]['enabled'];
    }
}