<?php

namespace App\Services;

use App\Exceptions\Event\AlreadyJoinedException;
use App\Exceptions\Event\EventNotFoundException;
use App\Exceptions\Event\ForbiddenException;
use App\Exceptions\Event\NotParticipantException;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EventService
{
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

    /**
     * @throws EventNotFoundException
     */
    public function showEvent($id): Event
    {
        $event = Event::with(['creator', 'participants'])->find($id);
        if (! $event) {
            throw new EventNotFoundException;
        }

        return $event;
    }

    /**
     * @throws AlreadyJoinedException
     * @throws EventNotFoundException
     */
    public function joinEventById($id): void
    {
        $event = Event::with('participants')->find($id);
        if (! $event) {
            throw new EventNotFoundException;
        }
        if ($event->participants()->where('user_id', Auth::id())->exists()) {
            throw new AlreadyJoinedException;
        }
        $event->participants()->attach(Auth::id());
    }

    /**
     * @throws NotParticipantException
     * @throws EventNotFoundException
     */
    public function leaveEventById($id): void
    {
        $event = Event::with('participants')->find($id);
        if (! $event) {
            throw new EventNotFoundException;
        }
        if (! $event->participants->contains(Auth::id())) {
            throw new NotParticipantException;
        }
        $event->participants()->detach(Auth::id());
    }

    /**
     * @throws EventNotFoundException
     * @throws ForbiddenException
     */
    public function deleteEventById($id): void
    {
        $event = Event::find($id);
        if (! $event) {
            throw new EventNotFoundException;
        }
        if ($event->creator_id !== Auth::id()) {
            throw new ForbiddenException;
        }
        $event->participants()->detach();
        $event->delete();
    }

    public function getMyEvents(): Collection
    {
        $userId = Auth::id();

        return Event::with(['creator', 'participants'])
            ->whereHas('participants', fn ($q) => $q->where('users.id', $userId))
            ->get();
    }

    private function formatUser(?User $user): array
    {
        return [
            'id' => $user?->id,
            'first_name' => $user?->first_name,
            'last_name' => $user?->last_name,
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

    private function formatEvents(Collection $events): array
    {
        return $events
            ->map(fn ($event) => $this->formatEvent($event))
            ->values()
            ->toArray();
    }

    public function getFormattedEvents(): array
    {
        $events = Event::with(['creator', 'participants'])->get();

        return $this->formatEvents($events);
    }

    /**
     * @throws EventNotFoundException
     */
    public function getFormattedEventById($id): array
    {
        $event = $this->showEvent($id);

        return $this->formatEvent($event);
    }

    public function getMyFormattedEvents(): array
    {
        return $this->formatEvents($this->getMyEvents());
    }
}
