<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { telegram } from "@/routes";
import { type BreadcrumbItem } from "@/types";
import { Head, router } from "@inertiajs/vue3";
import { computed, onBeforeUnmount, ref } from "vue";

type ReportType = "basic" | "audience";
type ReportStatus = "idle" | "queued" | "processing" | "completed" | "failed";

type ReportTaskState = {
    taskId: string | null;
    status: ReportStatus;
    message: string;
    downloadUrl: string | null;
    fileName: string | null;
    loading: boolean;
};

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
    analytics: null | {
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
    error: string | null;
}>();

const channel = ref(props.filters.channel ?? "");
const days = ref(props.filters.days ?? 30);
const daysOptions = [7, 14, 30, 90];
const asyncError = ref<string | null>(null);

const createTaskState = (): ReportTaskState => ({
    taskId: null,
    status: "idle",
    message: "",
    downloadUrl: null,
    fileName: null,
    loading: false,
});

const reportTasks = ref<Record<ReportType, ReportTaskState>>({
    basic: createTaskState(),
    audience: createTaskState(),
});

const pollTimers = new Map<ReportType, ReturnType<typeof setInterval>>();

const metricCards = computed(() => {
    if (!props.analytics) {
        return [];
    }

    const basic = props.analytics.basicMetrics as Record<string, number | null>;
    const audience = props.analytics.audienceQuality as Record<string, number | null>;

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

const submit = () => {
    router.get(
        telegram().url,
        {
            channel: channel.value,
            days: days.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const getCsrfToken = (): string => {
    const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null;

    return meta?.content ?? "";
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

            if (!response.ok) {
                throw new Error("Не удалось получить статус отчета.");
            }

            const data = await response.json();

            reportTasks.value[type] = {
                ...reportTasks.value[type],
                taskId: data.taskId,
                status: (data.status ?? "failed") as ReportStatus,
                message: data.message ?? "",
                downloadUrl: data.downloadUrl ?? null,
                fileName: data.fileName ?? null,
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
                message: error instanceof Error ? error.message : "Ошибка при опросе статуса отчета.",
                loading: false,
            };
        }
    }, 2000);

    pollTimers.set(type, timer);
};

const startReport = async (type: ReportType): Promise<void> => {
    asyncError.value = null;

    if (!channel.value.trim()) {
        asyncError.value = "Введите канал перед генерацией отчета.";
        return;
    }

    reportTasks.value[type] = {
        ...createTaskState(),
        loading: true,
        status: "queued",
        message: "Ставим задачу в очередь...",
    };

    try {
        const response = await fetch("/telegram/reports/start", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": getCsrfToken(),
            },
            body: JSON.stringify({
                channel: channel.value,
                days: days.value,
                type,
                lang: "ru",
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            const message = data?.message ?? "Не удалось запустить генерацию отчета.";
            throw new Error(message);
        }

        reportTasks.value[type] = {
            ...reportTasks.value[type],
            taskId: data.taskId,
            status: (data.status ?? "queued") as ReportStatus,
            message: data.message ?? "Задача поставлена в очередь.",
            loading: true,
        };

        pollReportStatus(type, data.taskId);
    } catch (error) {
        reportTasks.value[type] = {
            ...reportTasks.value[type],
            status: "failed",
            message: error instanceof Error ? error.message : "Ошибка запуска генерации отчета.",
            loading: false,
        };
    }
};

const formatValue = (value: number | null | undefined, percent = false): string => {
    if (value === null || value === undefined || Number.isNaN(value)) {
        return "-";
    }

    if (percent) {
        return `${value.toFixed(2)}%`;
    }

    return Number.isInteger(value) ? value.toLocaleString("ru-RU") : value.toFixed(2);
};

onBeforeUnmount(() => {
    clearPoll("basic");
    clearPoll("audience");
});
</script>

<template>
    <Head title="Telegram" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="glass-panel rounded-xl p-4">
                <form class="grid gap-3 md:grid-cols-[1fr_180px_auto]" @submit.prevent="submit">
                    <input
                        v-model="channel"
                        type="text"
                        placeholder="@username, t.me/channel или id"
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
                        type="submit"
                        class="rounded-lg border border-emerald-300/40 bg-emerald-400/20 px-4 py-2 text-sm font-medium text-emerald-100 transition hover:bg-emerald-400/30"
                    >
                        Построить аналитику
                    </button>
                </form>
            </div>

            <div v-if="error" class="glass-panel rounded-xl border border-rose-300/30 p-4 text-sm text-rose-200">
                {{ error }}
            </div>

            <div v-if="asyncError" class="glass-panel rounded-xl border border-rose-300/30 p-4 text-sm text-rose-200">
                {{ asyncError }}
            </div>

            <div v-if="analytics" class="glass-panel rounded-xl p-4">
                <div class="mb-3 text-sm font-medium text-white/80">PDF отчеты (асинхронно)</div>
                <div class="grid gap-3 md:grid-cols-2">
                    <div class="rounded-lg border border-white/15 bg-white/5 p-3">
                        <div class="text-sm text-white/70">Базовые метрики</div>
                        <div class="mt-2 flex items-center gap-2">
                            <button
                                type="button"
                                class="rounded-lg border border-cyan-300/40 bg-cyan-400/20 px-3 py-1.5 text-sm font-medium text-cyan-100 transition hover:bg-cyan-400/30"
                                :disabled="reportTasks.basic.loading"
                                @click="startReport('basic')"
                            >
                                {{ reportTasks.basic.loading ? "Генерация..." : "Сформировать PDF" }}
                            </button>
                            <a
                                v-if="reportTasks.basic.status === 'completed' && reportTasks.basic.downloadUrl"
                                :href="reportTasks.basic.downloadUrl"
                                class="rounded-lg border border-emerald-300/40 bg-emerald-400/20 px-3 py-1.5 text-sm font-medium text-emerald-100 transition hover:bg-emerald-400/30"
                            >
                                Скачать
                            </a>
                        </div>
                        <div v-if="reportTasks.basic.message" class="mt-2 text-xs text-white/70">
                            {{ reportTasks.basic.message }}
                        </div>
                    </div>

                    <div class="rounded-lg border border-white/15 bg-white/5 p-3">
                        <div class="text-sm text-white/70">Качество аудитории</div>
                        <div class="mt-2 flex items-center gap-2">
                            <button
                                type="button"
                                class="rounded-lg border border-cyan-300/40 bg-cyan-400/20 px-3 py-1.5 text-sm font-medium text-cyan-100 transition hover:bg-cyan-400/30"
                                :disabled="reportTasks.audience.loading"
                                @click="startReport('audience')"
                            >
                                {{ reportTasks.audience.loading ? "Генерация..." : "Сформировать PDF" }}
                            </button>
                            <a
                                v-if="reportTasks.audience.status === 'completed' && reportTasks.audience.downloadUrl"
                                :href="reportTasks.audience.downloadUrl"
                                class="rounded-lg border border-emerald-300/40 bg-emerald-400/20 px-3 py-1.5 text-sm font-medium text-emerald-100 transition hover:bg-emerald-400/30"
                            >
                                Скачать
                            </a>
                        </div>
                        <div v-if="reportTasks.audience.message" class="mt-2 text-xs text-white/70">
                            {{ reportTasks.audience.message }}
                        </div>
                    </div>
                </div>
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
