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
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Configures services, when the configurations is already merged.
 */
class ConfigureServicesListener
{
    use ServicesTrait;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

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
     * Configures the services.
     *
     * @param \Es\Modules\ModulesEvent The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $services = $this->getServices();
        $config   = $this->getConfig();
        if (isset($config['services'])) {
            $servicesConfig = (array) $config['services'];
            $services->add($servicesConfig);
        }
    }
}
