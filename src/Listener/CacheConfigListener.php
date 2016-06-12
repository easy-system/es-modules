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

use Es\Cache\Adapter\AbstractCache;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Stores the system configuration in cache and restores it, if the
 * configuration was previously stored and the cache is enabled.
 */
class CacheConfigListener
{
    use ServicesTrait;

    /**
     * The cache adapter.
     *
     * @var \Es\Cache\Adapter\AbstractCache
     */
    protected $cache;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * Sets the cache.
     *
     * @param \Es\Cache\Adapter\AbstractCache $cache The cache adapter
     */
    public function setCache(AbstractCache $cache)
    {
        $this->cache = $cache->withNamespace('system');
    }

    /**
     * Gets the cache.
     *
     * @return \Es\Cache\Adapter\AbstractCache The cache adapter
     */
    public function getCache()
    {
        if (! $this->cache) {
            $services = $this->getServices();
            $cache    = $services->get('Cache');
            $this->setCache($cache);
        }

        return $this->cache;
    }

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
     * Restores the system configuration from cache.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function doRestore(ModulesEvent $event)
    {
        $cache = $this->getCache();
        if (! $cache->isEnabled()) {
            return;
        }
        $data = $cache->get('config');
        if (! $data) {
            return;
        }
        $services = $this->getServices();
        $services->set('Config', $data);
        $event->stopPropagation(true);
    }

    /**
     * Stores the system configuration to cache.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function doStore(ModulesEvent $event)
    {
        $cache = $this->getCache();
        if (! $cache->isEnabled()) {
            return;
        }
        $config = $this->getConfig();
        $cache->set('config', $config);
    }
}
