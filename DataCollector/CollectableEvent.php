<?php

namespace Adadgio\BetterProfilerBundle\DataCollector;

use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Your services can extend this class to avoid over crowding
 * them with data collection events getters and setters.
 */
class CollectableEvent
{
    /**
     * @var Symfony Event
     */
    private $name;

    /**
     * @var array Array of events for data collection purposes
     */
    private $stopwatch;

    /**
     * @var array Array of events for data collection purposes
     */
    private $properties = array(
        'memory'    => null,
        'duration'  => null,
        'trace'     => null,
    );

    /**
     * Event constructor
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->set('name', $name); // also set as a property

        $this->stopwatch = new Stopwatch();
    }

    /**
     * Event destructor (stop the stopwatch in case)
     */
    public function __destruct()
    {
        if ($this->stopwatch->isStarted($this->name)) {
            $this->stopwatch->stop($this->name);
        }
    }

    /**
     * Start an event with the stopwatch
     */
    public function start()
    {
        $this->stopwatch->start($this->name);

        return $this;
    }

    /**
     * Stop the stopwatch and add basic properties.
     */
    public function stop()
    {
        $event = $this->stopwatch->stop($this->name);

        // set basic properties for the CollectableEvent
        $this->set('memory', $this->formatBytes($event->getMemory(), 'MB'));
        $this->set('duration', $event->getDuration());

        return $this;
    }

    public function addTrace($trace)
    {
        $this->set('trace', $trace);

        return $this;
    }

    /**
     * Get event property
     */
    public function get($property)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : null;
    }
    
    /**
     * Get event property
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set event property
     */
    public function set($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }

    /**
     * Converts bytes to mega octets.
     */
    private function formatBytes($size, $unit = '') {
        if( (!$unit && $size >= 1<<30) || $unit == 'GB'){
            return number_format($size/(1<<30),2).' GB';
        }

        if( (!$unit && $size >= 1<<20) || $unit == 'MB') {
            return round(number_format($size/(1<<20),2), 1).' MB';
        }

        if( (!$unit && $size >= 1<<10) || $unit == 'KB') {
            return number_format($size/(1<<10),2).' KB';
        }

        return number_format($size).' bytes';
    }
}
