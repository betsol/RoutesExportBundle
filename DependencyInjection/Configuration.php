<?php

namespace Betsol\RoutesExportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('betsol_routes_export')
            ->children()
                ->arrayNode('presets')
                    ->prototype('array')
                        ->children()
                            ->append($this->addPatternsNode('include'))
                            ->append($this->addPatternsNode('exclude'))
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function addPatternsNode($name)
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder
            ->root($name)
                ->cannotBeOverwritten()
                ->prototype('array')
                    ->children()
                        ->scalarNode('pattern')
                    ->end()
                ->end()
            ->end()
        ;
    }
}