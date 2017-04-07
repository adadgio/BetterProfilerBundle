<?php

namespace Adadgio\BetterProfilerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('adadgio_better_profiler');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->scalarNode('enabled')->defaultValue(true)->end()
                ->arrayNode('collectable_services')->isRequired()
                    
                    ->prototype('array')
                        ->children()
                            ->scalarNode('id')->cannotBeEmpty()->defaultValue(null)->end()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue(null)->end()
                        ->end()
                    ->end()

                ->end()

            ->end();

        return $treeBuilder;
    }
}
