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
use Es\System\SystemEvent;

/**
 * Dispatcher of modules event.
 */
class EventDispatcher
{
    use EventsTrait, ServicesTrait;

    /**
     * The modules event.
     *
     * @var \Es\Modules\ModulesEvent
     */
    protected $event;

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
