<?php

namespace Adadgio\BetterProfilerBundle\Service;

use Adadgio\BetterProfilerBundle\DataCollector\CollectableEvent;
use Adadgio\BetterProfilerBundle\DataCollector\CollectableService;
use Adadgio\BetterProfilerBundle\DataCollector\CollectableServiceInterface;

class DemoService extends CollectableService implements CollectableServiceInterface
{
    public function __construct()
    {

    }

    public function doSomething()
    {
        $event = (new CollectableEvent('1st event'))->start();
        // sleep(1.7);

        $event->stop();
        $this->addCollectedEvent($event);
    }

    public function doAnotherThing()
    {
        $event = (new CollectableEvent('2nd event'))->start();
        // sleep(1.67);

        $event->stop();
        $event->addTrace('');
        $this->addCollectedEvent($event);
    }
}
