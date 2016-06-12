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

use Es\Services\ServicesInterface;
use ReflectionClass;

/**
 * Implements the core functionality of custom Module.
 */
abstract class AbstractModule
{
    /**
     * The module directory.
     *
     * @var string
     */
    private $moduleDir = '';

    /**
     * The module config.
     *
     * @var null|array
     */
    private $config;

    /**
     * Bootstrap the module.
     *
     * If your module need bootstrap, you can override this method in your
     * module.
     *
     * @codeCoverageIgnore
     *
     * @param \Es\Services\ServicesInterface $services The services
     */
    public function bootstrap(ServicesInterface $services)
    {
        // TODO: Your code here
    }

    /**
     * Gets the module directory.
     *
     * @return string The module directory
     */
    final public function getModuleDir()
    {
        if (! $this->moduleDir) {
            $reflection      = new ReflectionClass(static::class);
            $this->moduleDir = dirname($reflection->getFileName());
        }

        return $this->moduleDir;
    }

    /**
     * Gets the system configuration, which is necessary for the module.
     *
     * @return array The system configuration
     */
    final public function getConfig()
    {
        if (null === $this->config) {
            $this->config = [];

            $configDir  = $this->getModuleDir() . DIRECTORY_SEPARATOR . 'config';
            $configFile = $configDir . DIRECTORY_SEPARATOR . 'system.config.php';
            if (file_exists($configFile)) {
                $this->config = (array) require $configFile;
            }
        }

        return $this->config;
    }
}
