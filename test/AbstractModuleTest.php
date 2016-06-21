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

class AbstractModuleTest extends \PHPUnit_Framework_TestCase
{
    protected $fooDir;
    protected $barDir;

    public function setUp()
    {
        $files        = __DIR__ . PHP_DS . 'files';
        $this->fooDir = $files . PHP_DS . 'Foo';
        $this->barDir = $files . PHP_DS . 'Bar';

        require_once $this->fooDir . PHP_DS . 'Module.php';
        require_once $this->barDir . PHP_DS . 'Module.php';
    }

    public function testGetModuleDir()
    {
        $foo = new \Foo\Module();
        $this->assertSame($this->fooDir, $foo->getModuleDir());
        $bar = new \Bar\Module();
        $this->assertSame($this->barDir, $bar->getModuleDir());
    }

    public function testGetConfigReturnsArray()
    {
        $bar = new \Bar\Module();
        $this->assertSame([], $bar->getConfig());
    }

    public function testGetConfigReturnsConfig()
    {
        $foo        = new \Foo\Module();
        $configDir  = $this->fooDir . PHP_DS . 'config';
        $configFile = $configDir . PHP_DS . 'system.config.php';
        $config     = (array) require $configFile;
        $this->assertSame($config, $foo->getConfig());
    }
}
