<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules\Test;

use Es\Modules\Modules;
use ReflectionProperty;

class ModulesTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $modules = new Modules();
        $module  = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $reflection = new ReflectionProperty($modules, 'modules');
        $reflection->setAccessible(true);
        $container = $reflection->getValue($modules);
        $this->assertTrue(isset($container['foo']));
        $this->assertSame($module, $container['foo']);
    }

    public function testRemoveReturnsSelf()
    {
        $modules = new Modules();
        $this->assertSame($modules, $modules->remove('foo'));
    }

    public function testRemoveRemovesModule()
    {
        $modules = new Modules();
        $module  = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $modules->remove('foo');
        $reflection = new ReflectionProperty($modules, 'modules');
        $reflection->setAccessible(true);
        $container = $reflection->getValue($modules);
        $this->assertFalse(isset($container['foo']));
    }

    public function testHas()
    {
        $modules = new Modules();
        $module  = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $this->assertTrue($modules->has('foo'));
        $modules->remove('foo');
        $this->assertFalse($modules->has('foo'));
    }

    public function testGetRaiseExceptionIfModuleNotExists()
    {
        $modules = new Modules();
        $this->setExpectedException('RuntimeException');
        $modules->get('foo');
    }

    public function testGetGetsAnModule()
    {
        $modules = new Modules();
        $module  = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $this->assertSame($module, $modules->get('foo'));
    }

    public function testCount()
    {
        $modules = new Modules();
        $this->assertSame(0, $modules->count());
        $module = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $this->assertSame(1, $modules->count());
    }

    public function testGetIterator()
    {
        $modules = new Modules();
        $module  = $this->getMockForAbstractClass('Es\Modules\AbstractModule');
        $modules->set('foo', $module);
        $reflection = new ReflectionProperty($modules, 'modules');
        $reflection->setAccessible(true);
        $container = $reflection->getValue($modules);
        $iterator  = $modules->getIterator();
        $this->assertInstanceOf('ArrayIterator', $iterator);
        $this->assertSame($container, $iterator->getArrayCopy());
    }
}
