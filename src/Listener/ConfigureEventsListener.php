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

use Es\Events\EventsInterface;
use Es\Modules\ModulesEvent;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Configure events, when the configurations is already merged.
 */
class ConfigureEventsListener
{
    use ServicesTrait;

    /**
     * The events.
     *
     * @var \Es\Events\EventsInterface
     */
    protected $events;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * Sets the events.
     *
     * @param \Es\Events\EventsInterface $events The events
     */
    public function setEvents(EventsInterface $events)
    {
        $this->events = $events;
    }

    /**
     * Gets the events.
     *
     * @return \Es\Events\EventsInterface The events
     */
    public function getEvents()
    {
        if (! $this->events) {
            $services = $this->getServices();
            $events   = $services->get('Events');
            $this->setEvents($events);
        }

        return $this->events;
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
