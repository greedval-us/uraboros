<?php

namespace App\Http\Controllers;

use App\Modules\Analytics\TelegramAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramAnalyticsController extends Controller
{
    public function __construct(
        private readonly TelegramAnalyticsService $analyticsService
    ) {}

    public function fetch(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'group_id' => ['required', 'string'],
            'days' => ['required', 'integer', 'min:1', 'max:365'],
            'report_type' => ['required', 'string'],
        ]);

        $report = $this->analyticsService->fetchGroupReport(
            $validated['group_id'],
            (int) $validated['days'],
            $validated['report_type']
        );

        return response()->json($report);
    }
}
