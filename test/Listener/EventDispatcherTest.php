<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules\Test\Listener;

use Es\Events\Events;
use Es\Modules\Listener\EventDispatcher;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemEvent;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEvents()
    {
        $events   = new Events();
        $services = new Services();
        $services->set('Events', $events);

        $dispatcher = new EventDispatcher();
        $dispatcher->setServices($services);
        $this->assertSame($events, $dispatcher->getEvents());
    }

    public function testSetEvents()
    {
        $events     = new Events();
        $dispatcher = new EventDispatcher();
        $dispatcher->setEvents($events);
        $this->assertSame($events, $dispatcher->getEvents());
    }

    public function testGetEvent()
    {
        $dispatcher = new EventDispatcher();
        $this->assertInstanceOf('Es\Modules\ModulesEvent', $dispatcher->getEvent());
    }

    public function testSetEvent()
    {
        $event      = new ModulesEvent();
        $dispatcher = new EventDispatcher();
        $dispatcher->setEvent($event);
        $this->assertSame($event, $dispatcher->getEvent());
    }

    public function testInvoke()
    {
        $dispatcher = new EventDispatcher();
        $events     = $this->getMock('Es\Events\Events');
        $dispatcher->setEvents($events);

        $expects = [
            ModulesEvent::LOAD_MODULES,
            ModulesEvent::MERGE_CONFIG,
            ModulesEvent::APPLY_CONFIG,
            ModulesEvent::BOOTSTRAP,
        ];

        $events
            ->expects($this->atLeastOnce())
            ->method('trigger')
            ->will($this->returnCallback(
                function ($event) use ($events, &$expects) {
                    $this->assertTrue($event->getName() == array_shift($expects));

                    return $events;
                }
            ));

        $dispatcher(new SystemEvent());
        $this->assertEmpty($expects);
    }
}
