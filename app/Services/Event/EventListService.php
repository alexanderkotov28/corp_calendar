<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EventListService
{
    public function list(User $user, int $month, int $year)
    {
        $first_day = Carbon::create($year, $month);
        $query = Event::with('createdBy', 'users', 'departments')
            ->whereBetween('start_date', [$first_day, (clone $first_day)->endOfMonth()]);

        if (!$user->is_admin) {
            $query->where('created_by', $user->id)
                ->orWhere(function (Builder $query) use ($user) {
                    $query->whereHas('users', function (Builder $query) use ($user) {
                        $query->where('id', $user->id);
                    })->orWhereHas('department', function (Builder $query) use ($user) {
                        $query->where('id', $user->department_id);
                    });
                });
        }

        return $query->get();
    }


    public function participants(Event $event): Collection
    {
        return $this->getDepartmentParticipantsQuery($event)
            ->union($this->getUserParticipantsQuery($event))
            ->get();
    }

    protected function getDepartmentParticipantsQuery(Event $event)
    {
        return DB::table('event_department')
            ->select('users.id', 'users.name')
            ->leftJoin('users', 'users.department_id', '=', 'event_department.department_id')
            ->where('event_department.event_id', $event->id);
    }

    protected function getUserParticipantsQuery(Event $event)
    {
        return DB::table('event_user')
            ->select('users.id', 'users.name')
            ->leftJoin('users', 'users.id', '=', 'event_user.user_id')
            ->where('event_user.event_id', $event->id);
    }
}
