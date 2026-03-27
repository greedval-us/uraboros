<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { telegram } from "@/routes";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";
import { computed, onBeforeUnmount, ref } from "vue";

type AnalyticsPayload = {
    group: {
        titleGroup: string | null;
        findGroup: string | null;
        idGroup: number | null;
        participantsCount: number | null;
    };
    period: {
        from: string;
        to: string;
        days: number;
    };
    basicMetrics: Record<string, number | null | Record<string, unknown>>;
    audienceQuality: Record<string, number | null | Record<string, unknown>>;
};

type ReportType = "basic" | "audience" | "funnel" | "user_leaders" | "full_report" | "user";
type ReportStatus = "idle" | "queued" | "processing" | "completed" | "failed";

type ReportTaskState = {
    taskId: string | null;
    status: ReportStatus;
    message: string;
    downloadUrl: string | null;
    loading: boolean;
};

const reportDefinitions: Array<{ type: ReportType; label: string; target: "group" | "user" }> = [
    { type: "basic", label: "Базовые метрики", target: "group" },
    { type: "audience", label: "Качество аудитории", target: "group" },
    { type: "funnel", label: "Воронка вовлеченности", target: "group" },
    { type: "user_leaders", label: "Лидеры активности", target: "group" },
    { type: "full_report", label: "Полный отчет", target: "group" },
    { type: "user", label: "Отчет по пользователю", target: "user" },
];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Telegram",
        href: telegram().url,
    },
];

const props = defineProps<{
    filters: {
        channel: string;
        days: number;
    };
}>();

const channel = ref(props.filters.channel ?? "");
const userId = ref("");
const days = ref(props.filters.days ?? 30);
const daysOptions = [7, 14, 30, 90];

const analytics = ref<AnalyticsPayload | null>(null);
const analyticsLoading = ref(false);
const analyticsError = ref<string | null>(null);

const previewLoading = ref(false);
const previewError = ref<string | null>(null);
const previewType = ref<ReportType | null>(null);
const previewData = ref<Record<string, unknown> | null>(null);
const previewMeta = ref<{ entity?: { title?: string | null; id?: string | number | null }; period?: { from: string; to: string } } | null>(null);

const createTaskState = (): ReportTaskState => ({
    taskId: null,
    status: "idle",
    message: "",
    downloadUrl: null,
    loading: false,
});

const reportTasks = ref<Record<ReportType, ReportTaskState>>({
    basic: createTaskState(),
    audience: createTaskState(),
    funnel: createTaskState(),
    user_leaders: createTaskState(),
    full_report: createTaskState(),
    user: createTaskState(),
});

const pollTimers = new Map<ReportType, ReturnType<typeof setInterval>>();

const getCsrfToken = (): string => {
    const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null;

    return meta?.content ?? "";
};

const postJson = async (url: string, payload: Record<string, unknown>) => {
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": getCsrfToken(),
        },
        body: JSON.stringify(payload),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data?.message ?? "Ошибка запроса.");
    }

    return data;
};

const loadAnalytics = async (): Promise<void> => {
    analyticsError.value = null;
    analyticsLoading.value = true;

    try {
        const data = await postJson("/telegram/analytics/load", {
            channel: channel.value,
            days: days.value,
        });

        analytics.value = data.analytics as AnalyticsPayload;
    } catch (error) {
        analytics.value = null;
        analyticsError.value = error instanceof Error ? error.message : "Не удалось загрузить аналитику.";
    } finally {
        analyticsLoading.value = false;
    }
};

const resolveTarget = (type: ReportType): string => {
    return type === "user" ? userId.value.trim() : channel.value.trim();
};

const clearPoll = (type: ReportType): void => {
    const timer = pollTimers.get(type);

    if (timer) {
        clearInterval(timer);
        pollTimers.delete(type);
    }
};

const pollReportStatus = (type: ReportType, taskId: string): void => {
    clearPoll(type);

    const timer = setInterval(async () => {
        try {
            const response = await fetch(`/telegram/reports/status/${taskId}`, {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data?.message ?? "Не удалось получить статус.");
            }

            reportTasks.value[type] = {
                ...reportTasks.value[type],
                taskId: data.taskId,
                status: (data.status ?? "failed") as ReportStatus,
                message: data.message ?? "",
                downloadUrl: data.downloadUrl ?? null,
                loading: data.status === "queued" || data.status === "processing",
            };

            if (data.status === "completed" || data.status === "failed") {
                clearPoll(type);
            }
        } catch (error) {
            clearPoll(type);
            reportTasks.value[type] = {
                ...reportTasks.value[type],
                status: "failed",
                message: error instanceof Error ? error.message : "Ошибка опроса статуса.",
                loading: false,
            };
        }
    }, 2000);

    pollTimers.set(type, timer);
};

const startReport = async (type: ReportType): Promise<void> => {
    const target = resolveTarget(type);

    reportTasks.value[type] = {
        ...createTaskState(),
        loading: true,
        status: "queued",
        message: "Ставим задачу в очередь...",
    };

    if (!target) {
        reportTasks.value[type] = {
            ...createTaskState(),
            status: "failed",
            message: type === "user" ? "Введите id_user для user-отчета." : "Введите канал для отчета.",
            loading: false,
        };
        return;
    }

    try {
        const data = await postJson("/telegram/reports/start", {
            target,
            days: days.value,
            type,
            lang: "ru",
        });

        reportTasks.value[type] = {
            ...reportTasks.value[type],
            taskId: data.taskId,
            status: (data.status ?? "queued") as ReportStatus,
            message: data.message ?? "Задача создана.",
            loading: true,
        };

        pollReportStatus(type, data.taskId);
    } catch (error) {
        reportTasks.value[type] = {
            ...createTaskState(),
            status: "failed",
            message: error instanceof Error ? error.message : "Не удалось запустить отчет.",
            loading: false,
        };
    }
};

const loadPreview = async (type: ReportType): Promise<void> => {
    previewError.value = null;
    previewLoading.value = true;

    const target = resolveTarget(type);

    if (!target) {
        previewLoading.value = false;
        previewError.value = type === "user" ? "Введите id_user для предпросмотра." : "Введите канал для предпросмотра.";
        return;
    }

    try {
        const data = await postJson("/telegram/reports/preview", {
            target,
            days: days.value,
            type,
            lang: "ru",
        });

        previewType.value = type;
        previewData.value = data.viewData ?? null;
        previewMeta.value = {
            entity: data.entity,
            period: data.period,
        };
    } catch (error) {
        previewData.value = null;
        previewError.value = error instanceof Error ? error.message : "Не удалось загрузить предпросмотр.";
    } finally {
        previewLoading.value = false;
    }
};

const metricCards = computed(() => {
    if (!analytics.value) {
        return [];
    }

    const basic = analytics.value.basicMetrics as Record<string, number | null>;
    const audience = analytics.value.audienceQuality as Record<string, number | null>;

    return [
        { label: "Публикации", value: basic.allPublications },
        { label: "Активные пользователи", value: basic.allActiveUsers },
        { label: "ER", value: basic.engagementRate, percent: true },
        { label: "Комментарии / пост", value: basic.commentsPerPost },
        { label: "Реакции / пост", value: basic.reactionsPerPost },
        { label: "Пишущие / участники", value: audience.writerToMembersAll, percent: true },
        { label: "Пишущие / вовлеченные", value: audience.writerToShareAll, percent: true },
    ];
});

const formatValue = (value: number | null | undefined, percent = false): string => {
    if (value === null || value === undefined || Number.isNaN(value)) {
        return "-";
    }

    if (percent) {
        return `${value.toFixed(2)}%`;
    }

    return Number.isInteger(value) ? value.toLocaleString("ru-RU") : value.toFixed(2);
};

const collectCharts = (value: unknown, acc: string[] = []): string[] => {
    if (typeof value === "string" && value.startsWith("data:image")) {
        acc.push(value);
    } else if (Array.isArray(value)) {
        value.forEach((item) => collectCharts(item, acc));
    } else if (value && typeof value === "object") {
        Object.values(value as Record<string, unknown>).forEach((item) => collectCharts(item, acc));
    }

    return acc;
};

const previewCharts = computed(() => collectCharts(previewData.value));

onBeforeUnmount(() => {
    reportDefinitions.forEach((item) => clearPoll(item.type));
});
</script>

<template>
    <Head title="Telegram" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="glass-panel rounded-xl p-4">
                <div class="grid gap-3 md:grid-cols-[1fr_220px_180px_auto]">
                    <input
                        v-model="channel"
                        type="text"
                        placeholder="Канал: @username, t.me/channel или id"
                        class="w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white outline-none placeholder:text-white/50 focus:border-white/40"
                    />
                    <input
                        v-model="userId"
                        type="text"
                        placeholder="id_user (для user отчета)"
                        class="w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white outline-none placeholder:text-white/50 focus:border-white/40"
                    />
                    <select
                        v-model.number="days"
                        class="rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white outline-none focus:border-white/40"
                    >
                        <option v-for="option in daysOptions" :key="option" :value="option">
                            {{ option }} дней
                        </option>
                    </select>
                    <button
                        type="button"
                        class="rounded-lg border border-emerald-300/40 bg-emerald-400/20 px-4 py-2 text-sm font-medium text-emerald-100 transition hover:bg-emerald-400/30"
                        :disabled="analyticsLoading"
                        @click="loadAnalytics"
                    >
                        {{ analyticsLoading ? "Загрузка..." : "Загрузить аналитику" }}
                    </button>
                </div>
            </div>

            <div v-if="analyticsError" class="glass-panel rounded-xl border border-rose-300/30 p-4 text-sm text-rose-200">
                {{ analyticsError }}
            </div>

            <div class="glass-panel rounded-xl p-4">
                <div class="mb-3 text-sm font-medium text-white/80">Асинхронные PDF-отчеты (6 типов)</div>
                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                    <div v-for="item in reportDefinitions" :key="item.type" class="rounded-lg border border-white/15 bg-white/5 p-3">
                        <div class="text-sm text-white/80">{{ item.label }}</div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <button
                                type="button"
                                class="rounded-lg border border-cyan-300/40 bg-cyan-400/20 px-3 py-1.5 text-sm font-medium text-cyan-100 transition hover:bg-cyan-400/30"
                                :disabled="reportTasks[item.type].loading"
                                @click="startReport(item.type)"
                            >
                                {{ reportTasks[item.type].loading ? "Генерация..." : "PDF" }}
                            </button>
                            <button
                                type="button"
                                class="rounded-lg border border-violet-300/40 bg-violet-400/20 px-3 py-1.5 text-sm font-medium text-violet-100 transition hover:bg-violet-400/30"
                                :disabled="previewLoading"
                                @click="loadPreview(item.type)"
                            >
                                Данные
                            </button>
                            <a
                                v-if="reportTasks[item.type].status === 'completed' && reportTasks[item.type].downloadUrl"
                                :href="reportTasks[item.type].downloadUrl"
                                class="rounded-lg border border-emerald-300/40 bg-emerald-400/20 px-3 py-1.5 text-sm font-medium text-emerald-100 transition hover:bg-emerald-400/30"
                            >
                                Скачать
                            </a>
                        </div>
                        <div v-if="reportTasks[item.type].message" class="mt-2 text-xs text-white/70">
                            {{ reportTasks[item.type].message }}
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="previewError" class="glass-panel rounded-xl border border-rose-300/30 p-4 text-sm text-rose-200">
                {{ previewError }}
            </div>

            <div v-if="previewData" class="glass-panel rounded-xl p-4">
                <div class="text-sm font-medium text-white/80">
                    Веб-представление PDF данных: {{ previewType }}
                </div>
                <div class="mt-1 text-xs text-white/60">
                    {{ previewMeta?.entity?.title || previewMeta?.entity?.id || "-" }} |
                    {{ previewMeta?.period?.from || "-" }} - {{ previewMeta?.period?.to || "-" }}
                </div>

                <div v-if="previewCharts.length" class="mt-4 grid gap-3 md:grid-cols-2">
                    <img
                        v-for="(chart, index) in previewCharts"
                        :key="index"
                        :src="chart"
                        alt="chart"
                        class="w-full rounded-lg border border-white/10 bg-white"
                    />
                </div>

                <pre class="mt-4 max-h-[420px] overflow-auto rounded-lg border border-white/10 bg-black/30 p-3 text-xs text-white/80">{{ JSON.stringify(previewData, null, 2) }}</pre>
            </div>

            <div v-if="analytics" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="glass-panel rounded-xl p-4 md:col-span-3">
                    <div class="text-sm text-white/70">Канал</div>
                    <div class="mt-1 text-xl font-semibold text-white">
                        {{ analytics.group.titleGroup || analytics.group.findGroup || "Без названия" }}
                    </div>
                    <div class="mt-2 text-sm text-white/70">
                        ID: {{ analytics.group.idGroup ?? "-" }} | Участников:
                        {{ formatValue(analytics.group.participantsCount) }} | Период:
                        {{ analytics.period.from }} - {{ analytics.period.to }}
                    </div>
                </div>

                <div v-for="card in metricCards" :key="card.label" class="glass-panel rounded-xl p-4">
                    <div class="text-sm text-white/70">{{ card.label }}</div>
                    <div class="mt-2 text-2xl font-semibold text-white">
                        {{ formatValue(card.value as number | null, card.percent) }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
