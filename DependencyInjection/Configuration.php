<?php

namespace Carlosv2\HermesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('hermes')
            ->children()
                ->booleanNode('keep_copy')->defaultFalse()->end()
                ->booleanNode('prevent_delivery')->defaultTrue()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
