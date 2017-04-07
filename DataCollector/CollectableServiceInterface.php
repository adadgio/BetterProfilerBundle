<?php

namespace Adadgio\BetterProfilerBundle\DataCollector;

interface CollectableServiceInterface
{
    public function getCollectedEvents();

    public function addCollectedEvent(CollectableEvent $event);
}
