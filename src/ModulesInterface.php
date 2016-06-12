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

/**
 * The interface of collection of modules.
 */
interface ModulesInterface extends \Countable, \IteratorAggregate
{
    /**
     * Sets the module.
     *
     * @param string         $name   The module name
     * @param AbstractModule $module The instance of module class
     *
     * @return self
     */
    public function set($name, AbstractModule $module);

    /**
     * Removes the module.
     *
     * @param string $name The module name
     *
     * @return self
     */
    public function remove($name);

    /**
     * Checks whether there is a module.
     *
     * @param string $name The module name
     *
     * @return bool Returns true on success, false otherwise
     */
    public function has($name);

    /**
     * Gets the module.
     *
     * @param string $name The module name
     *
     * @throws \RuntimeException If module is not found
     *
     * @return AbstractModule The module
     */
    public function get($name);
}
