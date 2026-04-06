<?php

namespace App\Http\Controllers;

use App\Models\RaceResult;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'actor_role' => ['required', 'in:teacher,student'],
            'name' => ['required', 'string', 'max:100'],
            'text' => ['required', 'string', 'min:30', 'max:1000'],
            'user_name' => ['required', 'string', 'max:60'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        if ($payload['actor_role'] !== 'teacher') {
            return response()->json(['message' => 'Only teachers can create rooms.'], 403);
        }

        $room = Room::create([
            'code' => strtoupper(Str::random(6)),
            'name' => $payload['name'],
            'text' => $payload['text'],
            'status' => 'waiting',
            'created_by' => $payload['user_id'] ?? null,
        ]);

        RaceResult::create([
            'room_id' => $room->id,
            'user_id' => $payload['user_id'] ?? null,
            'user_name' => $payload['user_name'],
            'progress' => 0,
            'wpm' => 0,
            'accuracy' => 100,
            'is_spectator' => false,
        ]);

        $this->publishRaceEvent([
            'type' => 'room_created',
            'roomCode' => $room->code,
            'payload' => [
                'name' => $room->name,
            ],
        ]);

        return response()->json([
            'room' => $room,
        ], 201);
    }

    public function show(Room $room): JsonResponse
    {
        $room->load(['raceResults' => fn ($query) => $query->orderByDesc('wpm')]);

        return response()->json([
            'room' => $room,
        ]);
    }

    public function join(Request $request, Room $room): JsonResponse
    {
        $payload = $request->validate([
            'actor_role' => ['required', 'in:teacher,student'],
            'user_name' => ['required', 'string', 'max:60'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        if ($payload['actor_role'] !== 'student') {
            return response()->json(['message' => 'Only students can join rooms.'], 403);
        }

        $existing = RaceResult::where('room_id', $room->id)
            ->where(function ($query) use ($payload): void {
                if (! empty($payload['user_id'])) {
                    $query->where('user_id', $payload['user_id']);
                }

                $query->orWhere('user_name', $payload['user_name']);
            })
            ->first();

        $isSpectator = $room->status !== 'waiting';

        if (! $existing) {
            $existing = RaceResult::create([
                'room_id' => $room->id,
                'user_id' => $payload['user_id'] ?? null,
                'user_name' => $payload['user_name'],
                'progress' => 0,
                'wpm' => 0,
                'accuracy' => 100,
                'is_spectator' => $isSpectator,
            ]);
        }

        $this->publishRaceEvent([
            'type' => 'user_joined',
            'roomCode' => $room->code,
            'payload' => [
                'userName' => $existing->user_name,
                'userId' => $existing->user_id,
                'spectator' => (bool) $existing->is_spectator,
            ],
        ]);

        return response()->json([
            'room_code' => $room->code,
            'user' => [
                'id' => $existing->user_id,
                'name' => $existing->user_name,
                'spectator' => (bool) $existing->is_spectator,
            ],
            'race_text' => $room->text,
            'status' => $room->status,
        ]);
    }

    private function publishRaceEvent(array $event): void
    {
        try {
            Redis::publish('race_events', json_encode($event, JSON_THROW_ON_ERROR));
        } catch (\Throwable $exception) {
            Log::warning('Redis unavailable; race event publish skipped.', [
                'type' => $event['type'] ?? null,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
