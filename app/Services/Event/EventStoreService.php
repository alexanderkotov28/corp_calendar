<?php

namespace App\Services\Event;

use App\Data\EventData;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventStoreService
{
    public function create(EventData $eventData)
    {
        /** @var Event $event */
        $event = Event::create($eventData->getEventAttributes());

        $event->users()->sync($eventData->users);
        $event->departments()->sync($eventData->departments);

        return $event;
    }

    public function update(Event $event, EventData $eventData)
    {
        $event->update($eventData->getEventAttributes());

        $event->users()->sync($eventData->users);
        $event->departments()->sync($eventData->departments);
        $event->refresh();

        return $event;
    }
}
