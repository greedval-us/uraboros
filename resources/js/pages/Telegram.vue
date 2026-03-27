<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { telegram } from "@/routes";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";

type ReportResult = {
    type: string;
    group: Record<string, unknown>;
    period: {
        from: string;
        to: string;
        days: number;
    };
    analytics: Record<string, unknown>;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Telegram",
        href: telegram().url,
    },
];

const groupId = ref("");
const days = ref(7);
const reportType = ref("basic_metrics");
const result = ref<ReportResult | null>(null);
const error = ref<string | null>(null);
const loading = ref(false);

const reportTypes = [
    { value: "basic_metrics", label: "Базовые метрики" },
    { value: "funnel", label: "Воронка" },
    { value: "audience_quality", label: "Качество аудитории" },
    { value: "user_leaders", label: "Лидеры активности" },
    { value: "full_report", label: "Полный отчет" },
];

const hasResult = computed(() => !!result.value);

const submit = async () => {
    error.value = null;
    result.value = null;
    loading.value = true;

    try {
        const response = await fetch("/telegram/analytics", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document
                        .querySelector("meta[name='csrf-token']")
                        ?.getAttribute("content") ?? "",
            },
            body: JSON.stringify({
                group_id: groupId.value.trim(),
                days: days.value,
                report_type: reportType.value,
            }),
        });

        if (!response.ok) {
            const payload = await response.json().catch(() => ({}));
            throw new Error(payload?.message || "Не удалось получить данные");
        }

        result.value = await response.json();
    } catch (err: unknown) {
        error.value = err instanceof Error ? err.message : "Ошибка запроса";
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <Head title="Telegram" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex w-full max-w-5xl flex-col gap-6 px-4 py-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h1 class="text-2xl font-semibold text-slate-900">
                    Telegram аналитика
                </h1>
                <p class="mt-1 text-sm text-slate-600">
                    Запроси аналитику по группе без подключения модуля бота.
                </p>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <label class="flex flex-col gap-2 text-sm text-slate-700">
                        Группа (ID или @username)
                        <input
                            v-model="groupId"
                            type="text"
                            placeholder="@mygroup"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-slate-400"
                        />
                    </label>

                    <label class="flex flex-col gap-2 text-sm text-slate-700">
                        Период (дней)
                        <input
                            v-model.number="days"
                            type="number"
                            min="1"
                            max="365"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-slate-400"
                        />
                    </label>

                    <label class="flex flex-col gap-2 text-sm text-slate-700">
                        Тип отчета
                        <select
                            v-model="reportType"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-slate-400"
                        >
                            <option
                                v-for="type in reportTypes"
                                :key="type.value"
                                :value="type.value"
                            >
                                {{ type.label }}
                            </option>
                        </select>
                    </label>
                </div>

                <div class="mt-5 flex flex-wrap gap-3">
                    <button
                        class="rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:bg-slate-400"
                        :disabled="loading"
                        @click="submit"
                    >
                        {{ loading ? "Запрашиваю..." : "Получить данные" }}
                    </button>
                    <p v-if="error" class="text-sm text-red-600">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">
                    Результат
                </h2>

                <div
                    v-if="!hasResult"
                    class="mt-4 rounded-lg border border-dashed border-slate-200 p-6 text-sm text-slate-500"
                >
                    Данных пока нет. Заполните форму и отправьте запрос.
                </div>

                <div v-else class="mt-4">
                    <pre
                        class="max-h-[420px] overflow-auto rounded-lg bg-slate-900 p-4 text-xs text-slate-100"
                    >{{ JSON.stringify(result, null, 2) }}</pre>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
