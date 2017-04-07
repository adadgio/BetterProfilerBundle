<?php

namespace Adadgio\BetterProfilerBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class DefaultCollector extends DataCollector implements DataCollectorInterface
{
    protected $services;
    protected $container;
    protected $configuration;

    public function __construct(ContainerInterface $container, array $configuration) // UserConfigurator $userConfigurator
    {
        $this->services = array();
        $this->container = $container;
        $this->configuration = $configuration;

        if (true === $this->configuration['enabled']) {
            $this->enableDataCollector($this->configuration);
        }
    }

    protected function enableDataCollector()
    {
        foreach ($this->configuration['collectable_services'] as $definition)
        {
            $serviceId = $definition['id'];
            $serviceClass = $definition['class'];

            $reflection = new \ReflectionClass($serviceClass);
            $className = $reflection->getShortName();

            if (false === $reflection->hasMethod('getCollectedEvents')) {
                throw new \Exception(sprintf('The service [%s] needs a ::getCollectedEvents() method to be able to use in the data collector DefaultCollector', $className));
            }

            $this->services[$className] = $this->container->get($serviceId);
        }

        $this->container = null;
    }

    /**
     * Required because implements DataCollectorInterface
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $events = array();

        foreach ($this->services as $serviceName => $service) {
            $events[$serviceName] = $service->getCollectedEvents();
        }

        $this->data = array('events' => $events, 'enabled' => $this->configuration['enabled']);
    }

    public function getData()
    {
        return $this->data;
    }

    public function countEvents()
    {
        $counter = 0;
        foreach ($this->data['events'] as $serviceName => $events) {
            if (count($events) > 0) {
                $counter += count($events);
            }
        }

        return $counter;
    }

    /**
     * Required because implements DataCollectorInterface
     */
    public function getName()
    {
        return 'adadgio_better_profiler.default_collector';
    }
}
