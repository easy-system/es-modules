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
use Es\Modules\ModulesTrait;
use Es\Services\Provider;

/**
 * Registers paths to the module classes in system class loader.
 * By convention, the module classes, other than itself "Module" class, must be
 * in the "src" directory of module.
 */
class RegistrationListener
{
    use ModulesTrait;

    /**
     * Sets the class loader.
     *
     * @param \Es\Loader\ClassLoader $loader The class loader
     */
    public function setLoader(ClassLoader $loader)
    {
        Provider::getServices()->set('ClassLoader', $loader);
    }

    /**
     * Gets the class loader.
     *
     * @return \Es\Loader\ClassLoader The class loader
     */
    public function getLoader()
    {
        return Provider::getServices()->get('ClassLoader');
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
