<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(): JsonResponse
    {
        $events = $this->eventService->getEvents();
        $result = $events->map(fn ($event) => $this->eventService->formatEvent($event))
            ->values()
            ->toArray();

        return ApiResponse::success($result);
    }

    public function store(EventStoreRequest $request): JsonResponse
    {
        $event = $this->eventService->createEvent($request->validated());

        return ApiResponse::success($this->eventService->formatEvent($event));
    }

    public function join($id): JsonResponse
    {
        $event = Event::with('participants')->findOrFail($id);
        $result = $this->eventService->joinEvent($event);
        if ($result === 'already_joined') {
            return ApiResponse::error('Вы уже участвуете в этом событии', 409);
        }

        return ApiResponse::success('joined');
    }

    public function leave($id): JsonResponse
    {
        $event = Event::with('participants')->findOrFail($id);
        $result = $this->eventService->leaveEvent($event);
        if ($result === 'not_participant') {
            return ApiResponse::error('Вы не являетесь участником события', 409);
        }

        return ApiResponse::success('leave');
    }

    public function destroy($id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $result = $this->eventService->deleteEvent($event);
        if ($result === 'forbidden') {
            return ApiResponse::error('Нет прав на удаление', 403);
        }

        return ApiResponse::success('deleted');
    }
}
