<?php /** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\OAuthApiConnectorBundle\Security\ApiConnector;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Andreo\GuzzleBundle\Request\Options;

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
                    ->scalarNode('decorator_id')->defaultNull()->end()
                    ->scalarNode('lazy')->defaultFalse()->end()
                    ->scalarNode('config_provider_id')->defaultNull()->end()
                    ->arrayNode('options')->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode(Options::DTO_SUPPORTS)
                            ->canBeDisabled()
                                ->children()
                                    ->scalarNode(Options::FORMAT)->defaultValue('json')->end()
                                ->end()
                            ->end()
                            ->scalarNode(RequestOptions::TIMEOUT)->defaultNull()->end()
                            ->scalarNode(RequestOptions::CONNECT_TIMEOUT)->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $clientsNode;
    }
}
