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
use Es\System\SystemEvent;

/**
 * Dispatcher of modules event.
 */
class EventDispatcher
{
    use ServicesTrait;

    /**
     * The events.
     *
     * @var \Es\Events\EventsInterface
     */
    protected $events;

    /**
     * The modules event.
     *
     * @var \Es\Modules\ModulesEvent
     */
    protected $event;

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
     * Sets the modules event.
     *
     * @param \Es\Modules\ModulesEvent $event The modules event
     */
    public function setEvent(ModulesEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Gets the modules event.
     *
     * @return \Es\Modules\ModulesEvent The modules event
     */
    public function getEvent()
    {
        if (! $this->event) {
            $this->event = new ModulesEvent();
        }

        return $this->event;
    }

    /**
     * Dispatches modules event.
     *
     * @param \Es\System\SystemEvent $systemEvent The system event
     */
    public function __invoke(SystemEvent $systemEvent)
    {
        $event  = $this->getEvent();
        $events = $this->getEvents();

        $events
            ->trigger($event(ModulesEvent::LOAD_MODULES))
            ->trigger($event(ModulesEvent::MERGE_CONFIG))
            ->trigger($event(ModulesEvent::APPLY_CONFIG))
            ->trigger($event(ModulesEvent::BOOTSTRAP));
    }
}
