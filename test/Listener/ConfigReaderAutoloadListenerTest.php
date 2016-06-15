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

use Es\Loader\Normalizer;
use Es\Modules\Listener\ConfigReaderAutoloadListener;
use Es\Modules\ModulesEvent;
use Es\System\SystemConfig;

class ConfigReaderAutoloadListenerTest extends \PHPUnit_Framework_TestCase
{
    public function invalidAutoloadDirDataProvider()
    {
        $dirs = [
            false,
            true,
            [],
            new \stdClass(),
            '',
            'not-existent-directory',
        ];
        $return = [];
        foreach ($dirs as $dir) {
            $return[] = [$dir];
        }

        return $return;
    }

    /**
     * @dataProvider invalidAutoloadDirDataProvider
     */
    public function testSetAutoloadDirRaiseExceptionIfReceivedDirIsInvalid($dir)
    {
        $listener = new ConfigReaderAutoloadListener();
        $this->setExpectedException('InvalidArgumentException');
        $listener->setAutoloadDir($dir);
    }

    public function testGetAutoloadDir()
    {
        $dir      = dirname(__DIR__) . '/files/config/autoload';
        $listener = new ConfigReaderAutoloadListener();
        $listener->setAutoloadDir($dir);
        $this->assertSame(Normalizer::path($dir), $listener->getAutoloadDir());
    }

    public function testInvoke()
    {
        $dir      = dirname(__DIR__) . '/files/config/autoload';
        $listener = new ConfigReaderAutoloadListener();
        $listener->setAutoloadDir($dir);
        $config = new SystemConfig();
        $listener->setConfig($config);

        $listener(new ModulesEvent());

        $this->assertTrue(isset($config['foo']));
        $this->assertSame('bar', $config['foo']);
    }
}
