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

use Es\Modules\ModulesEvent;
use Es\Modules\ModulesInterface;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Merges the system configuration from the configurations provided by modules.
 */
class ConfigReaderModulesListener
{
    use ServicesTrait;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * The modules.
     *
     * @var \Es\Modules\ModulesInterface
     */
    protected $modules;

    /**
     * Sets the system configuration.
     *
     * @param \Es\System\ConfigInterface $config The system configuration
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the system configuration.
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
     * Sets the modules.
     *
     * @param \Es\Modules\ModulesInterface $modules The modules
     */
    public function setModules(ModulesInterface $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Gets the modules.
     *
     * @return \Es\Modules\ModulesInterface The modules
     */
    public function getModules()
    {
        if (! $this->modules) {
            $services = $this->getServices();
            $modules  = $services->get('Modules');
            $this->setModules($modules);
        }

        return $this->modules;
    }

    /**
     * Reads the system configuration from modules and merges it.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $config  = $this->getConfig();
        $modules = $this->getModules();
        foreach ($modules as $module) {
            $config->merge((array) $module->getConfig());
        }
    }
}
