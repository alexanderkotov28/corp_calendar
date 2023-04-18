<?php

namespace App\Http\Controllers;

use App\Data\EventData;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Services\Event\EventListService;
use App\Services\Event\EventStoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(EventListService $service, Request $request)
    {
        return EventResource::collection($service->list(auth()->user(), $request->get('month'), $request->get('year')));
    }

    public function store(EventData $data, EventStoreService $service)
    {
        return new EventResource($service->create($data));
    }

    public function update(EventData $data, EventStoreService $service, Event $event)
    {
        return new EventResource($service->update($event, $data));
    }

    public function destroy(Event $event)
    {
        DB::transaction(function () use ($event) {
            $event->departments()->detach();
            $event->users()->detach();
            $event->delete();
        });
    }

    public function participants(Event $event, EventListService $service)
    {
        return $service->participants($event);
    }
}
