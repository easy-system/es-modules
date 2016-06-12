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

use Es\Loader\ModuleLoader;
use Es\Modules\Listener\LoaderListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class LoaderListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetModules()
    {
        $modules  = new Modules();
        $services = new Services();
        $services->set('Modules', $modules);
        $listener = new LoaderListener();
        $listener->setServices($services);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testSetModules()
    {
        $modules  = new Modules();
        $listener = new LoaderListener();
        $listener->setModules($modules);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testGetLoader()
    {
        $loader   = new ModuleLoader();
        $services = new Services();
        $services->set('ModuleLoader', $loader);
        $listener = new LoaderListener();
        $listener->setServices($services);
        $this->assertSame($loader, $listener->getLoader());
    }

    public function testSetLoader()
    {
        $loader   = new ModuleLoader();
        $listener = new LoaderListener();
        $listener->setLoader($loader);
        $this->assertSame($loader, $listener->getLoader());
    }

    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new LoaderListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new LoaderListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testInvoke()
    {
        $initialConfig = [
            'vendors' => __DIR__ . DIRECTORY_SEPARATOR . 'files',
            'modules' => [
                'Foo',
                'Bar',
            ],
        ];
        $config  = new SystemConfig($initialConfig);
        $modules = new Modules();
        $loader  = new ModuleLoader();

        $listener = new LoaderListener();

        $listener->setModules($modules);
        $listener->setLoader($loader);
        $listener->setConfig($config);

        $listener(new ModulesEvent());

        $this->assertTrue($modules->has('Foo'));
        $this->assertTrue($modules->has('Bar'));
    }
}
