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

use Es\Events\Listeners;
use Es\Modules\Listener\ConfigureListenersListener;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigureListenersListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetListeners()
    {
        $listeners = new Listeners();
        $services  = new Services();
        $services->set('Listeners', $listeners);
        $listener = new ConfigureListenersListener();
        $listener->setServices($services);
        $this->assertSame($listeners, $listener->getListeners());
    }

    public function testSetListeners()
    {
        $listeners = new Listeners();
        $listener  = new ConfigureListenersListener();
        $listener->setListeners($listeners);
        $this->assertSame($listeners, $listener->getListeners());
    }

    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new ConfigureListenersListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new ConfigureListenersListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testInvoke()
    {
        $listenersConfig = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $config              = new SystemConfig();
        $config['listeners'] = $listenersConfig;

        $listeners = $this->getMock(Listeners::CLASS);
        $listener  = new ConfigureListenersListener();
        $listener->setListeners($listeners);
        $listener->setConfig($config);

        $listeners
            ->expects($this->once())
            ->method('add')
            ->with($this->identicalTo($listenersConfig));

        $listener(new ModulesEvent());
    }
}
