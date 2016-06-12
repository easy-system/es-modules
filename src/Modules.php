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

use ArrayIterator;
use RuntimeException;

/**
 * The collection of modules.
 */
class Modules implements ModulesInterface
{
    /**
     * The modules.
     *
     * @var array
     */
    protected $modules = [];

    /**
     * Sets the module.
     *
     * @param string         $name   The module name
     * @param AbstractModule $module The instance of module class
     *
     * @return self
     */
    public function set($name, AbstractModule $module)
    {
        $this->modules[(string) $name] = $module;

        return $this;
    }

    /**
     * Removes the module.
     *
     * @param string $name The module name
     *
     * @return self
     */
    public function remove($name)
    {
        if (isset($this->modules[$name])) {
            unset($this->modules[$name]);
        }

        return $this;
    }

    /**
     * Checks whether there is a module.
     *
     * @param string $name The module name
     *
     * @return bool Returns true on success, false otherwise
     */
    public function has($name)
    {
        return isset($this->modules[$name]);
    }

    /**
     * Gets the module.
     *
     * @param string $name The module name
     *
     * @throws \RuntimeException If module is not found
     *
     * @return AbstractModule The module
     */
    public function get($name)
    {
        if (! isset($this->modules[$name])) {
            throw new RuntimeException(
                sprintf(
                    'Module "%s" is not found',
                    $name
                )
            );
        }

        return $this->modules[$name];
    }

    /**
     * Gets count of modules.
     *
     * @return int The number of modules
     */
    public function count()
    {
        return count($this->modules);
    }

    /**
     * Gets iterator.
     *
     * @return \ArrayIterator The iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->modules);
    }
}
