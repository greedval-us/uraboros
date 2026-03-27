<?php

namespace App\Http\Controllers;

use App\Modules\Analytics\TelegramAnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TelegramAnalyticsController extends Controller
{
    public function __invoke(Request $request, TelegramAnalyticsService $service): Response
    {
        $validated = $request->validate([
            'channel' => ['nullable', 'string', 'max:255'],
            'days' => ['nullable', 'integer', 'in:7,14,30,90'],
        ]);

        $channel = trim((string) ($validated['channel'] ?? ''));
        $days = (int) ($validated['days'] ?? 30);

        $analytics = null;
        $error = null;

        if ($channel !== '') {
            try {
                $analytics = $service->getChannelAnalytics($channel, $days);
            } catch (Throwable $exception) {
                $error = $exception->getMessage();
            }
        }

        return Inertia::render('Telegram', [
            'filters' => [
                'channel' => $channel,
                'days' => $days,
            ],
            'analytics' => $analytics,
            'error' => $error,
        ]);
    }
}
