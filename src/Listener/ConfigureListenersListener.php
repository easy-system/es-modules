<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Modules\Listener;

use Es\Events\ListenersInterface;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Configures listeners, when the configurations is already merged.
 */
class ConfigureListenersListener
{
    use ServicesTrait;

    /**
     * The listeners.
     *
     * @var \Es\Events\ListenersInterface
     */
    protected $listeners;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * Sets the listeners.
     *
     * @param \Es\Events\ListenersInterface $listeners The listeners
     */
    public function setListeners(ListenersInterface $listeners)
    {
        $this->listeners = $listeners;
    }

    /**
     * Gets the listeners.
     *
     * @return \Es\Events\ListenersInterface The listeners
     */
    public function getListeners()
    {
        if (! $this->listeners) {
            $services  = $this->getServices();
            $listeners = $services->get('Listeners');
            $this->setListeners($listeners);
        }

        return $this->listeners;
    }

    /**
     * Sets the configuration.
     *
     * @param \Es\System\ConfigInterface $config The system configuration
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the configuration.
     *
     * @return \Es\System\Config The system configuration
     */
    public function getConfig()
    {
        if (! $this->config) {
            $services = $this->getServices();
            $config   = $services->get('Config');
            $this->setConfig($config);
        }

        return $this->config;
    }

    /**
     * Configures the listeners.
     *
     * @param \Es\Modules\ModulesEvent The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $listeners = $this->getListeners();
        $config    = $this->getConfig();
        if (isset($config['listeners'])) {
            $listenersConfig = (array) $config['listeners'];
            $listeners->add($listenersConfig);
        }
    }
}
