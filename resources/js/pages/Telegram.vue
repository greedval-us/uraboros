<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { telegram } from "@/routes";
import { type BreadcrumbItem } from "@/types";
import { Head, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";

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

const formatValue = (value: number | null | undefined, percent = false): string => {
    if (value === null || value === undefined || Number.isNaN(value)) {
        return "-";
    }

    if (percent) {
        return `${value.toFixed(2)}%`;
    }

    return Number.isInteger(value) ? value.toLocaleString("ru-RU") : value.toFixed(2);
};
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
