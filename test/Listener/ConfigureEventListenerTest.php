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
use Es\System\SystemConfig;

class ConfigureEventListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $events           = $this->getMock(Events::CLASS);
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
