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

/**
 * Calls the Module::bootstrap() method of each module.
 */
class BootstrapListener
{
    use ServicesTrait;

    /**
     * The modules.
     *
     * @var \Es\Modules\ModulesInterface
     */
    protected $modules;

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
     * Calls the bootstrap method of each module.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $services = $this->getServices();
        $modules  = $this->getModules();

        foreach ($modules as $module) {
            $module->bootstrap($services);
        }
    }
}
