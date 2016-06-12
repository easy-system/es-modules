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
use Es\Modules\Listener\ConfigureEventsListener;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigureEventListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEvents()
    {
        $events   = new Events();
        $services = new Services();
        $services->set('Events', $events);
        $listener = new ConfigureEventsListener();
        $listener->setServices($services);
        $this->assertSame($events, $listener->getEvents());
    }

    public function testSetEvents()
    {
        $events   = new Events();
        $listener = new ConfigureEventsListener();
        $listener->setEvents($events);
        $this->assertSame($events, $listener->getEvents());
    }

    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new ConfigureEventsListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new ConfigureEventsListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testInvoke()
    {
        $events           = $this->getMock('Es\Events\Events');
        $config           = new SystemConfig();
        $config['events'] = [
            ['foo', 'bar', 'baz', 100],
        ];
        $listener = new ConfigureEventsListener();
        $listener->setEvents($events);
        $listener->setConfig($config);
        $events
            ->expects($this->once())
            ->method('attach')
            ->with(
                $this->identicalTo('foo'),
                $this->identicalTo('bar'),
                $this->identicalTo('baz'),
                $this->identicalTo(100)
            );

        $listener(new ModulesEvent());
    }
}
