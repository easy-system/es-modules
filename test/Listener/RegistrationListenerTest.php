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

use Es\Loader\ClassLoader;
use Es\Modules\Listener\RegistrationListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\Services;

class RegistrationListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetModules()
    {
        $modules  = new Modules();
        $services = new Services();
        $services->set('Modules', $modules);
        $listener = new RegistrationListener();
        $listener->setServices($services);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testSetModules()
    {
        $modules  = new Modules();
        $listener = new RegistrationListener();
        $listener->setModules($modules);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testGetLoader()
    {
        $loader   = new ClassLoader();
        $services = new Services();
        $services->set('ClassLoader', $loader);
        $listener = new RegistrationListener();
        $listener->setServices($services);
        $this->assertSame($loader, $listener->getLoader());
    }

    public function testSetLoader()
    {
        $loader   = new ClassLoader();
        $listener = new RegistrationListener();
        $listener->setLoader($loader);
        $this->assertSame($loader, $listener->getLoader());
    }

    public function testInvoke()
    {
        $module = $this->getMock('Es\Modules\AbstractModule');
        $src    = $module->getModuleDir() . DIRECTORY_SEPARATOR . 'src';

        $loader  = $this->getMock('Es\Loader\ClassLoader');
        $modules = new Modules();
        $modules->set('foo', $module);

        $listener = new RegistrationListener();
        $listener->setModules($modules);
        $listener->setLoader($loader);

        $loader
            ->expects($this->once())
            ->method('registerPath')
            ->with(
                $this->identicalTo('foo'),
                $this->identicalTo($src)
            );

        $listener(new ModulesEvent());
    }
}
