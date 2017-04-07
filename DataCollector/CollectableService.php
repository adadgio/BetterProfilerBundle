<?php

namespace Adadgio\BetterProfilerBundle\DataCollector;

/**
 * Your services can extend this class to avoid over crowding
 * them with data collection events getters and setters.
 */
class CollectableService implements CollectableServiceInterface
{
    /**
     * @var array Array of events for data collection purposes
     */
    protected $collectedEvents = array();

    /**
     * Get events
     */
    public function getCollectedEvents()
    {
        return $this->collectedEvents;
    }

    /**
     * Get events
     */
    public function addCollectedEvent(CollectableEvent $event)
    {
        $this->collectedEvents[] = $event;

        return $this;
    }
}
