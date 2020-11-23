<?php


namespace Creonit\RestBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('creonit_rest');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('path_patterns')
                    ->defaultValue([])
                    ->example(['^/api', '^/api(?!/admin)'])
                    ->prototype('scalar')->end()
                ->end()
                ->variableNode('spec')
                ->defaultValue([])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
