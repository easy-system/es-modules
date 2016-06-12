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

use Es\Loader\ClassLoader;
use Es\Modules\ModulesEvent;
use Es\Modules\ModulesInterface;
use Es\Services\ServicesTrait;

/**
 * Registers paths to the module classes in system class loader.
 * By convention, the module classes, other than itself "Module" class, must be
 * in the "src" directory of module.
 */
class RegistrationListener
{
    use ServicesTrait;

    /**
     * The modules.
     *
     * @var \Es\Modules\ModulesInterface
     */
    protected $modules;

    /**
     * The class loader.
     *
     * @var \Es\Loader\ClassLoader
     */
    protected $loader;

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
     * Sets the class loader.
     *
     * @param \Es\Loader\ClassLoader $loader The class loader
     */
    public function setLoader(ClassLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the class loader.
     *
     * @return \Es\Loader\ClassLoader The class loader
     */
    public function getLoader()
    {
        if (! $this->loader) {
            $services = $this->getServices();
            $loader   = $services->get('ClassLoader');
            $this->setLoader($loader);
        }

        return $this->loader;
    }

    /**
     * Registers paths to the module classes in system class loader.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $modules = $this->getModules();
        $loader  = $this->getLoader();
        foreach ($modules as $namespace => $module) {
            $path = $module->getModuleDir() . DIRECTORY_SEPARATOR . 'src';
            $loader->registerPath($namespace, $path);
        }
    }
}
