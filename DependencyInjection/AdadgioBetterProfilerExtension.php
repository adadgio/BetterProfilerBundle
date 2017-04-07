<?php

namespace Adadgio\BetterProfilerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AdadgioBetterProfilerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // set all bundle parameters from configuration values
        $this->setBundleParameters($container, $config);
    }

    private function setBundleParameters($container, array $config = array())
    {
        $container->setParameter('adadgio_better_profiler', $config);
        $container->setParameter('adadgio_better_profiler.enabled', $config['enabled']);
        $container->setParameter('adadgio_better_profiler.collectable_services', $config['collectable_services']);
    }
}
