<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules;

use Es\Component\ComponentInterface;
use Es\System\SystemEvent;

/**
 * The system component.
 */
class Component implements ComponentInterface
{
    /**
     * The configuration of services.
     *
     * @var array
     */
    protected $servicesConfig = [
        'Modules' => 'Es\Modules\Modules',
    ];

    /**
     * The configuration of listeners.
     *
     * @var array
     */
    protected $listenersConfig = [
        'Es.Modules.Listener.EventDispatcher'              => 'Es\Modules\Listener\EventDispatcher',
        'Es.Modules.Listener.LoaderListener'               => 'Es\Modules\Listener\LoaderListener',
        'Es.Modules.Listener.RegistrationListener'         => 'Es\Modules\Listener\RegistrationListener',
        'Es.Modules.Listener.CacheConfigListener'          => 'Es\Modules\Listener\CacheConfigListener',
        'Es.Modules.Listener.ConfigReaderAutoloadListener' => 'Es\Modules\Listener\ConfigReaderAutoloadListener',
        'Es.Modules.Listener.ConfigReaderModulesListener'  => 'Es\Modules\Listener\ConfigReaderModulesListener',
        'Es.Modules.Listener.ConfigureServicesListener'    => 'Es\Modules\Listener\ConfigureServicesListener',
        'Es.Modules.Listener.ConfigureListenersListener'   => 'Es\Modules\Listener\ConfigureListenersListener',
        'Es.Modules.Listener.ConfigureEventsListener'      => 'Es\Modules\Listener\ConfigureEventsListener',
    ];

    /**
     * The configuration of events.
     *
     * @var array
     */
    protected $eventsConfig = [
        'EventDispatcher::__invoke' => [
            SystemEvent::BOOTSTRAP,
            'Es.Modules.Listener.EventDispatcher',
            '__invoke',
            1000
        ],
        'LoaderListener::__invoke' => [
            ModulesEvent::LOAD_MODULES,
            'Es.Modules.Listener.LoaderListener',
            '__invoke',
            2000
        ],
        'RegistrationListener::__invoke' => [
            ModulesEvent::LOAD_MODULES,
            'Es.Modules.Listener.RegistrationListener',
            '__invoke',
            1000
        ],
        'CacheConfigListener::doRestore' => [
            ModulesEvent::MERGE_CONFIG,
            'Es.Modules.Listener.CacheConfigListener',
            'doRestore',
            10000
        ],
        'ConfigReaderAutoloadListener::__invoke' => [
            ModulesEvent::MERGE_CONFIG,
            'Es.Modules.Listener.ConfigReaderAutoloadListener',
            '__invoke',
            6000
        ],
        'ConfigReaderModulesListener::__invoke' => [
            ModulesEvent::MERGE_CONFIG,
            'Es.Modules.Listener.ConfigReaderModulesListener',
            '__invoke',
            4000
        ],
        'CacheConfigListener::doStore' => [
            ModulesEvent::MERGE_CONFIG,
            'Es.Modules.Listener.CacheConfigListener',
            'doStore',
            -10000
        ],
        'ConfigureServicesListener::__invoke' => [
            ModulesEvent::APPLY_CONFIG,
            'Es.Modules.Listener.ConfigureServicesListener',
            '__invoke',
            11000
        ],
        'ConfigureListenersListener::__invoke' => [
            ModulesEvent::APPLY_CONFIG,
            'Es.Modules.Listener.ConfigureListenersListener',
            '__invoke',
            10000
        ],
        'ConfigureEventsListener::__invoke' => [
            ModulesEvent::APPLY_CONFIG,
            'Es.Modules.Listener.ConfigureEventsListener',
            '__invoke',
            9000
        ],
    ];

    /**
     * The current version of component.
     *
     * @var string
     */
    protected $version = '0.1.0';

    /**
     * Gets the current version of component.
     *
     * @return string The version of component
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Gets the configuration of services.
     *
     * @return array The configuration of services
     */
    public function getServicesConfig()
    {
        return $this->servicesConfig;
    }

    /**
     * Gets the configuration of listeners.
     *
     * @return array
     */
    public function getListenersConfig()
    {
        return $this->listenersConfig;
    }

    /**
     * Gets the configuration of events.
     *
     * @return array The configuration of events
     */
    public function getEventsConfig()
    {
        return $this->eventsConfig;
    }
}
