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

use Es\Events\EventsTrait;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigTrait;

/**
 * Configure events, when the configurations is already merged.
 */
class ConfigureEventsListener
{
    use ConfigTrait, EventsTrait, ServicesTrait;

    /**
     * Configures the events.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function __invoke(ModulesEvent $event)
    {
        $events = $this->getEvents();
        $config = $this->getConfig();
        if (isset($config['events'])) {
            $eventsConfig = (array) $config['events'];
            foreach ($eventsConfig as $item) {
                call_user_func_array([$events, 'attach'], $item);
            }
        }
    }
}
