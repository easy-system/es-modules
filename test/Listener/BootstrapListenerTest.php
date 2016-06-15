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

use Es\Modules\AbstractModule;
use Es\Modules\Listener\BootstrapListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesInterface;

class BootstrapListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $modules = new Modules();
        $module  = $this->getMock(AbstractModule::CLASS);
        $modules->set('foo', $module);
        $listener = new BootstrapListener();
        $listener->setModules($modules);

        $module
            ->expects($this->once())
            ->method('bootstrap')
            ->with($this->isInstanceOf(ServicesInterface::CLASS));

        $listener(new ModulesEvent());
    }
}
