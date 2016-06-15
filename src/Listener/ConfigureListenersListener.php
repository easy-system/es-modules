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

use Es\Events\ListenersTrait;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigTrait;

/**
 * Configures listeners, when the configurations is already merged.
 */
class ConfigureListenersListener
{
    use ConfigTrait, ListenersTrait, ServicesTrait;

    /**
     * Configures the listeners.
     *
     * @param \Es\Modules\ModulesEvent The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $listeners = $this->getListeners();
        $config    = $this->getConfig();
        if (isset($config['listeners'])) {
            $listenersConfig = (array) $config['listeners'];
            $listeners->add($listenersConfig);
        }
    }
}
