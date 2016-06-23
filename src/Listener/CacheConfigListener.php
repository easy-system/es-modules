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

use Es\Cache\AbstractCache;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigTrait;

/**
 * Stores the system configuration in cache and restores it, if the
 * configuration was previously stored and the cache is enabled.
 */
class CacheConfigListener
{
    use ConfigTrait, ServicesTrait;

    /**
     * The cache adapter.
     *
     * @var \Es\Cache\Adapter\AbstractCache
     */
    protected $cache;

    /**
     * Sets the cache.
     *
     * @param \Es\Cache\AbstractCache $cache The cache adapter
     */
    public function setCache(AbstractCache $cache)
    {
        $this->cache = $cache->withNamespace('system');
    }

    /**
     * Gets the cache.
     *
     * @return \Es\Cache\AbstractCache The cache adapter
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
     * Restores the system configuration from cache.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function doRestore(ModulesEvent $event)
    {
        $cache = $this->getCache();
        $data  = $cache->get('config');
        if ($data) {
            $services = $this->getServices();
            $services->set('Config', $data);
            $event->stopPropagation(true);
        }
    }

    /**
     * Stores the system configuration to cache.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function doStore(ModulesEvent $event)
    {
        $cache  = $this->getCache();
        $config = $this->getConfig();
        $cache->set('config', $config);
    }
}
