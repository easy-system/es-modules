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

use Es\Cache\AbstractCache;
use Es\Modules\Listener\CacheConfigListener;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class CacheConfigListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCache()
    {
        $services = new Services();
        $cache    = $this->getMock(AbstractCache::CLASS);
        $services->set('Cache', $cache);

        $listener = new CacheConfigListener();
        $listener->setServices($services);

        $cache
            ->expects($this->once())
            ->method('withNamespace')
            ->with($this->identicalTo('system'))
            ->will($this->returnValue($cache));

        $this->assertSame($cache, $listener->getCache());
    }

    public function testSetCache()
    {
        $cache    = $this->getMock(AbstractCache::CLASS);
        $listener = new CacheConfigListener();

        $cache
            ->expects($this->once())
            ->method('withNamespace')
            ->with($this->identicalTo('system'))
            ->will($this->returnValue($cache));

        $listener->setCache($cache);
        $this->assertSame($cache, $listener->getCache());
    }

    public function testDoRestore()
    {
        $config = new SystemConfig();
        $cache  = $this->getMock(AbstractCache::CLASS);

        $cache
            ->expects($this->once())
            ->method('withNamespace')
            ->with($this->identicalTo('system'))
            ->will($this->returnValue($cache));

        $services = new Services();
        $listener = new CacheConfigListener();
        $listener->setServices($services);
        $listener->setCache($cache);

        $cache
            ->expects($this->once())
            ->method('get')
            ->with($this->identicalTo('config'))
            ->will($this->returnValue($config));

        $event = new ModulesEvent();
        $listener->doRestore($event);

        $this->assertSame($config, $services->get('Config'));
        $this->assertTrue($event->propagationIsStopped());
    }

    public function testDoStore()
    {
        $config = new SystemConfig();
        $cache  = $this->getMock(AbstractCache::CLASS);

        $cache
            ->expects($this->once())
            ->method('withNamespace')
            ->with($this->identicalTo('system'))
            ->will($this->returnValue($cache));

        $listener = new CacheConfigListener();
        $listener->setConfig($config);
        $listener->setCache($cache);

        $cache
            ->expects($this->once())
            ->method('set')
            ->with(
                $this->identicalTo('config'),
                $this->identicalTo($config)
            );

        $listener->doStore(new ModulesEvent());
    }
}
