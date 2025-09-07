<?php

namespace App\Http\Controllers;

use App\Exceptions\Event\AlreadyJoinedException;
use App\Exceptions\Event\EventNotFoundException;
use App\Exceptions\Event\ForbiddenException;
use App\Exceptions\Event\NotParticipantException;
use App\Http\Requests\EventStoreRequest;
use App\Http\Responses\ApiResponse;
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
        return ApiResponse::success($this->eventService->getFormattedEvents());
    }

    public function store(EventStoreRequest $request): JsonResponse
    {
        $event = $this->eventService->createEvent($request->validated());

        return ApiResponse::success($this->eventService->formatEvent($event));
    }

    public function show($id): JsonResponse
    {
        try {
            $result = $this->eventService->getFormattedEventById($id);

            return ApiResponse::success($result);
        } catch (EventNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }

    public function join($id): JsonResponse
    {
        try {
            $this->eventService->joinEventById($id);

            return ApiResponse::success('joined');
        } catch (EventNotFoundException|AlreadyJoinedException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }

    public function leave($id): JsonResponse
    {
        try {
            $this->eventService->leaveEventById($id);

            return ApiResponse::success('leave');
        } catch (EventNotFoundException|NotParticipantException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }

    public function myEvents(): JsonResponse
    {
        return ApiResponse::success(
            $this->eventService->getMyFormattedEvents()
        );
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->eventService->deleteEventById($id);

            return ApiResponse::success('deleted');
        } catch (EventNotFoundException|ForbiddenException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }
}
