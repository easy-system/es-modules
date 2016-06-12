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

use Es\Loader\Normalizer;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;
use InvalidArgumentException;

/**
 * Provides merging of system configurations from configuration files in
 * specified directory. By default, this directory is "config/autoload/".
 */
class ConfigReaderAutoloadListener
{
    use ServicesTrait;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * The directory for autoloading of configuration files.
     *
     * @var string
     */
    protected $autoloadDir = 'config/autoload/';

    /**
     * Sets the configuration.
     *
     * @param \Es\System\ConfigInterface $config The system configuration
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the configuration.
     *
     * @return \Es\System\Config The system configuration
     */
    public function getConfig()
    {
        if (! $this->config) {
            $services = $this->getServices();
            $config   = $services->get('Config');
            $this->setConfig($config);
        }

        return $this->config;
    }

    /**
     * Sets the directory for autoloading of configuration files.
     *
     * @param string $dir The path to directory
     *
     * @throws \InvalidArgumentException If the received directory is not
     *                                   non-empty string or if this directory
     *                                   not exists
     */
    public function setAutoloadDir($dir)
    {
        if (! is_string($dir) || empty($dir)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid directory for autoload of configuration provided; '
                . 'must be a non-empty string, "%s" received.',
                is_object($dir) ? get_class($dir) : gettype($dir)
            ));
        }

        $dir = Normalizer::path($dir);

        if (! file_exists($dir) || ! is_dir($dir)) {
            throw new InvalidArgumentException(sprintf(
                'The directory "%s", specified for autoload of configurations, '
                . 'does not exists.',
                $dir
            ));
        }
        $this->autoloadDir = $dir;
    }

    /**
     * Gets the directory for autoloading of configuration files.
     *
     * @return string The path to directory
     */
    public function getAutoloadDir()
    {
        return $this->autoloadDir;
    }

    /**
     * Merges of system configurations from configuration files in specified
     * directory.
     *
     * @param ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $config = $this->getConfig();
        $dir    = $this->getAutoloadDir();
        $path   = $dir . '{{,*.}global,{,*.}local}.php';
        foreach (glob($path, GLOB_BRACE) as $file) {
            $item = require $file;
            $config->merge((array) $item);
        }
    }
}
