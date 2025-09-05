<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EventService
{
    public function getEvents(): Collection
    {
        return Event::with(['creator', 'participants'])->get();
    }

    public function createEvent(array $data): Event
    {
        $event = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'creator_id' => Auth::id(),
        ]);

        $event->participants()->attach(Auth::id());

        return $event->fresh(['creator', 'participants']);
    }

    public function joinEvent(Event $event): bool|string
    {
        if ($event->participants()
            ->where('user_id', Auth::id())
            ->exists()) {

            return 'already_joined';
        }
        $event->participants()->attach(Auth::id());

        return true;
    }

    public function leaveEvent(Event $event): bool|string
    {
        if (! $event->participants->contains(Auth::id())) {
            return 'not_participant';
        }
        $event->participants()->detach(Auth::id());

        return true;
    }

    public function deleteEvent(Event $event): bool|string
    {
        if ($event->creator_id !== Auth::id()) {
            return 'forbidden';
        }
        $event->participants()->detach();
        $event->delete();

        return true;
    }

    public function formatUser($user): array
    {
        if (! $user instanceof User) {
            return [
                'id' => null,
                'first_name' => null,
                'last_name' => null,
            ];
        }

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        ];
    }

    public function formatEvent($event): array
    {
        /** @var \Illuminate\Support\Collection<int,User> $participants */
        $participants = $event->participants;

        return [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'created_at' => $event->created_at,
            'creator' => $this->formatUser($event->creator),
            'participants' => $participants->map(function ($user) {
                return $this->formatUser($user);
            })->all(),
        ];
    }
}
