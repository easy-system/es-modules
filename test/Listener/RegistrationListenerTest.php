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
use Es\Modules\AbstractModule;
use Es\Modules\Listener\RegistrationListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\Services\ServicesTrait;

class RegistrationListenerTest extends \PHPUnit_Framework_TestCase
{
    use ServicesTrait;

    public function testGetLoader()
    {
        $loader   = new ClassLoader();
        $services = new Services();
        $services->set('ClassLoader', $loader);

        $this->setServices($services);
        $listener = new RegistrationListener();
        $this->assertSame($loader, $listener->getLoader());
    }

    public function testSetLoader()
    {
        $services = new Services();
        $this->setServices($services);

        $loader   = new ClassLoader();
        $listener = new RegistrationListener();
        $listener->setLoader($loader);
        $this->assertSame($loader, $services->get('ClassLoader'));
    }

    public function testInvoke()
    {
        $module = $this->getMock(AbstractModule::CLASS);
        $src    = $module->getModuleDir() . PHP_DS . 'src';

        $loader  = $this->getMock(ClassLoader::CLASS);
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
