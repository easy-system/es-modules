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

use Es\Modules\Listener\BootstrapListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\Services;

class BootstrapListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetModules()
    {
        $modules  = new Modules();
        $services = new Services();
        $services->set('Modules', $modules);
        $listener = new BootstrapListener();
        $listener->setServices($services);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testSetModules()
    {
        $modules  = new Modules();
        $listener = new BootstrapListener();
        $listener->setModules($modules);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testInvoke()
    {
        $modules = new Modules();
        $module  = $this->getMock('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $listener = new BootstrapListener();
        $listener->setModules($modules);

        $module
            ->expects($this->once())
            ->method('bootstrap')
            ->with($this->isInstanceOf('Es\Services\ServicesInterface'));

        $listener(new ModulesEvent());
    }
}
