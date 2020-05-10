<?php

declare(strict_types=1);


namespace Andreo\GuzzleBundle\DependencyInjection;


use Andreo\GuzzleBundle\Client\ClientInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DecorateClientPass implements CompilerPassInterface
{
    private string $decoratedClientTag;

    public function __construct(string $decoratedClientTag = 'andreo.guzzle_decorated_client')
    {
        $this->decoratedClientTag = $decoratedClientTag;
    }

    public function process(ContainerBuilder $container): void
    {
        $decoratedClients = $container->findTaggedServiceIds($this->decoratedClientTag);

        /**
         * @var string&ClientInterface $id
         * @var array<array<string, mixed>> $tagAttributes
         */
        foreach ($decoratedClients as $clientId => $tagAttributes) {
            $clientDef = $container->getDefinition($clientId);

            foreach ($tagAttributes as $attributes) {
                if ($container->hasDefinition($attributes['decorator_id'])) {
                    $clientDecoratorDef = $container->getDefinition($attributes['decorator_id']);
                } else {
                    $clientDecoratorDef = (new Definition($attributes['decorator_id']));
                }

                $clientDecoratorDef
                    ->setPrivate(true)
                    ->setLazy($clientDef->isLazy())
                    ->setDecoratedService($clientId, $attributes['decorator_id'] . '.inner')
                    ->setArguments([
                        new Reference($attributes['decorator_id'] . '.inner'),
                        ...$clientDecoratorDef->getArguments()
                    ]);

                $container->setDefinition($attributes['decorator_id'], $clientDecoratorDef);
            }
        }
    }
}