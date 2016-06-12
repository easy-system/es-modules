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

use Es\Loader\ModuleLoader;
use Es\Modules\ModulesEvent;
use Es\Modules\ModulesInterface;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Loads the modules specified in the system configuration.
 */
class LoaderListener
{
    use ServicesTrait;

    /**
     * The modules.
     *
     * @var \Es\Modules\ModulesInterface
     */
    protected $modules;

    /**
     * The loader of Module classes.
     *
     * @var \Es\Loader\ModuleLoader
     */
    protected $loader;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

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
     * Sets the loader.
     *
     * @param \Es\Loader\ModuleLoader $loader The loader of Module classes
     */
    public function setLoader(ModuleLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the loader.
     *
     * @return \Es\Loader\ModuleLoader The loader of Module classes
     */
    public function getLoader()
    {
        if (! $this->loader) {
            $services = $this->getServices();
            $loader   = $services->get('ModuleLoader');
            $this->setLoader($loader);
        }

        return $this->loader;
    }

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
     * Loads the modules.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $systemConfig  = $this->getConfig();
        $initialConfig = $systemConfig->getInitialConfig();

        $vendorsConfig = ['vendor', 'module'];
        if (isset($initialConfig['vendors'])) {
            $vendorsConfig = (array) $initialConfig['vendors'];
        }
        $loader = $this->getLoader();
        $loader->registerPaths($vendorsConfig);
        $loader->register();

        if (isset($initialConfig['modules'])) {
            $modules = $this->getModules();

            $modulesConfig = (array) $initialConfig['modules'];
            foreach ($modulesConfig as $namespace) {
                $moduleClass = $namespace . '\Module';
                $module      = new $moduleClass();
                $modules->set($namespace, $module);
            }
        }

        $loader->unregister();
    }
}
