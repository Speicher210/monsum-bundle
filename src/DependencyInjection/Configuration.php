<?php

namespace Speicher210\FastbillBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('speicher210_fastbill');

        $rootNode
            ->children()
                ->scalarNode('username')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('account_hash')
                    ->cannotBeEmpty()
                    ->defaultNull()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
