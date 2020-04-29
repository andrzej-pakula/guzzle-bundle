<?php /** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

namespace Andreo\GuzzleBundle\DependencyInjection;

use Andreo\GuzzleBundle\Configurator\ConfigProviderInterface;
use Andreo\OAuthApiConnectorBundle\Security\ApiConnector;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Andreo\GuzzleBundle\Client\RequestOptions;

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
                    ->scalarNode('configurator_factory_id')->defaultNull()->end()
                    ->arrayNode(RequestOptions::DTO_SUPPORTS)
                        ->canBeDisabled()
                        ->children()
                            ->enumNode(RequestOptions::FORMAT)
                                ->values(['json', 'xml'])
                                ->defaultValue('json')
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('options')->defaultValue([])
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode(GuzzleRequestOptions::TIMEOUT)->defaultNull()->end()
                                ->scalarNode(GuzzleRequestOptions::CONNECT_TIMEOUT)->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $clientsNode;
    }
}
