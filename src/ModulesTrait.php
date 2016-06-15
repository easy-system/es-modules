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

use Es\Services\Provider;

/**
 * The recommended way to interact with modules.
 */
trait ModulesTrait
{
    /**
     * Sets the modules.
     *
     * @param ModulesInterface $modules The modules
     */
    public function setModules(ModulesInterface $modules)
    {
        Provider::getServices()->set('Modules', $modules);
    }

    /**
     * Gets the modules.
     *
     * @return ModulesInterface $modules The modules
     */
    public function getModules()
    {
        return Provider::getServices()->get('Modules');
    }
}
