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
use Es\System\ConfigTrait;

/**
 * Configures services, when the configurations is already merged.
 */
class ConfigureServicesListener
{
    use ConfigTrait, ServicesTrait;

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
