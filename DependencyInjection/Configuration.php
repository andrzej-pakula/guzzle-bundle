<?php /** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\OAuthApiConnectorBundle\Security\ApiConnector;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('andreo_guzzle');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->append($this->getClientNode())
            ->end();

        return $treeBuilder;
    }

    private function getClientNode(): ArrayNodeDefinition
    {
        $clientsNode = new ArrayNodeDefinition('clients');

        $clientsNode
            ->arrayPrototype()
                ->children()
                    ->scalarNode('base_uri')->isRequired()->end()
                    ->scalarNode('timeout')->end()
                    ->scalarNode('connect_timeout')->end()
                    ->scalarNode('decorator_id')->end()
                ->end()
            ->end();

        return $clientsNode;
    }
}
