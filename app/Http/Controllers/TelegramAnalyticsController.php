<?php

namespace App\Http\Controllers;

use App\Modules\Analytics\TelegramAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TelegramAnalyticsController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Telegram', [
            'filters' => [
                'channel' => '',
                'days' => 30,
            ],
        ]);
    }

    public function load(Request $request, TelegramAnalyticsService $service): JsonResponse
    {
        $validated = $request->validate([
            'channel' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'in:7,14,30,90'],
        ]);

        try {
            $analytics = $service->getChannelAnalytics(
                trim((string) $validated['channel']),
                (int) $validated['days'],
            );

            return response()->json([
                'analytics' => $analytics,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }
}
