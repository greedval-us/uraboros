<?php

namespace App\Http\Controllers;

use App\Jobs\Analytics\GenerateTelegramReportJob;
use App\Modules\Analytics\TelegramReportBuildService;
use App\Modules\Analytics\TelegramReportTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TelegramReportController extends Controller
{
    public function start(Request $request, TelegramReportTaskService $taskService): JsonResponse
    {
        $validated = $request->validate([
            'target' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'in:7,14,30,90'],
            'type' => ['required', 'string', 'in:basic,audience,funnel,user_leaders,full_report,user'],
            'lang' => ['nullable', 'string', 'in:ru,en'],
        ]);

        $task = $taskService->create(
            userId: (int) $request->user()->id,
            target: trim((string) $validated['target']),
            days: (int) $validated['days'],
            type: (string) $validated['type'],
        );

        GenerateTelegramReportJob::dispatch(
            taskId: $task['taskId'],
            target: $task['target'],
            days: $task['days'],
            type: $task['type'],
            userId: $task['userId'],
            lang: (string) ($validated['lang'] ?? 'ru'),
        );

        return response()->json([
            'taskId' => $task['taskId'],
            'status' => $task['status'],
            'message' => $task['message'],
        ]);
    }

    public function preview(Request $request, TelegramReportBuildService $buildService): JsonResponse
    {
        $validated = $request->validate([
            'target' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'in:7,14,30,90'],
            'type' => ['required', 'string', 'in:basic,audience,funnel,user_leaders,full_report,user'],
            'lang' => ['nullable', 'string', 'in:ru,en'],
        ]);

        try {
            $build = $buildService->build(
                type: (string) $validated['type'],
                target: trim((string) $validated['target']),
                days: (int) $validated['days'],
                lang: (string) ($validated['lang'] ?? 'ru'),
            );

            return response()->json([
                'type' => $validated['type'],
                'entity' => $build['entity'],
                'period' => $build['period'],
                'viewData' => $build['viewData'],
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function status(Request $request, string $taskId, TelegramReportTaskService $taskService): JsonResponse
    {
        $task = $taskService->find($taskId);

        if ($task === null || (int) $task['userId'] !== (int) $request->user()->id) {
            return response()->json([
                'message' => 'Задача не найдена.',
            ], 404);
        }

        return response()->json([
            'taskId' => $task['taskId'],
            'status' => $task['status'],
            'message' => $task['message'],
            'downloadUrl' => $task['status'] === 'completed'
                ? route('telegram.reports.download', ['taskId' => $task['taskId']])
                : null,
            'fileName' => $task['fileName'],
        ]);
    }

    public function download(Request $request, string $taskId, TelegramReportTaskService $taskService)
    {
        $task = $taskService->find($taskId);

        if ($task === null || (int) $task['userId'] !== (int) $request->user()->id) {
            abort(404);
        }

        if (($task['status'] ?? null) !== 'completed' || empty($task['filePath'])) {
            abort(404);
        }

        $disk = Storage::disk('private');

        if (!$disk->exists($task['filePath'])) {
            abort(404);
        }

        return $disk->download($task['filePath'], (string) ($task['fileName'] ?? 'report.pdf'));
    }
}
