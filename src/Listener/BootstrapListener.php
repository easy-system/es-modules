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
use Es\Modules\ModulesTrait;
use Es\Services\ServicesTrait;

/**
 * Calls the Module::bootstrap() method of each module.
 */
class BootstrapListener
{
    use ModulesTrait, ServicesTrait;

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
