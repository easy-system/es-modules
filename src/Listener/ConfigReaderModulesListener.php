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
use Es\System\ConfigTrait;

/**
 * Merges the system configuration from the configurations provided by modules.
 */
class ConfigReaderModulesListener
{
    use ConfigTrait, ModulesTrait, ServicesTrait;

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
