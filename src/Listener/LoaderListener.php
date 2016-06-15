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
use Es\Modules\ModulesTrait;
use Es\Services\Provider;
use Es\System\ConfigTrait;

/**
 * Loads the modules specified in the system configuration.
 */
class LoaderListener
{
    use ConfigTrait, ModulesTrait;

    /**
     * Sets the loader.
     *
     * @param \Es\Loader\ModuleLoader $loader The loader of Module classes
     */
    public function setLoader(ModuleLoader $loader)
    {
        Provider::getServices()->set('ModuleLoader', $loader);
    }

    /**
     * Gets the loader.
     *
     * @return \Es\Loader\ModuleLoader The loader of Module classes
     */
    public function getLoader()
    {
        return Provider::getServices()->get('ModuleLoader');
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
