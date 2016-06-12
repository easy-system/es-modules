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

use Es\Modules\Listener\ConfigureServicesListener;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigureServicesListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new ConfigureServicesListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new ConfigureServicesListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testInvoke()
    {
        $servicesConfig = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $config             = new SystemConfig();
        $config['services'] = $servicesConfig;

        $services = $this->getMock('Es\Services\Services');
        $listener = new ConfigureServicesListener();
        $listener->setServices($services);
        $listener->setConfig($config);

        $services
            ->expects($this->once())
            ->method('add')
            ->with($this->identicalTo($servicesConfig));

        $listener(new ModulesEvent());
    }
}
