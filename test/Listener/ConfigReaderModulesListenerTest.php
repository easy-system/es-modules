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

use Es\Modules\Listener\ConfigReaderModulesListener;
use Es\Modules\Modules;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigReaderModulesListenerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $files  = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'files';
        $foo    = $files . DIRECTORY_SEPARATOR . 'Foo';
        $module = $foo . DIRECTORY_SEPARATOR . 'Module.php';
        require_once $module;
    }

    public function testGetModules()
    {
        $modules  = new Modules();
        $services = new Services();
        $services->set('Modules', $modules);
        $listener = new ConfigReaderModulesListener();
        $listener->setServices($services);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testSetModules()
    {
        $modules  = new Modules();
        $listener = new ConfigReaderModulesListener();
        $listener->setModules($modules);
        $this->assertSame($modules, $listener->getModules());
    }

    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new ConfigReaderModulesListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new ConfigReaderModulesListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testInvoke()
    {
        $modules = new Modules();
        $module  = new \Foo\Module();
        $modules->set('foo', $module);
        $config = new SystemConfig();

        $listener = new ConfigReaderModulesListener();

        $listener->setConfig($config);
        $listener->setModules($modules);

        $listener(new ModulesEvent());
        $this->assertSame($module->getConfig(), $config->toArray());
    }
}
