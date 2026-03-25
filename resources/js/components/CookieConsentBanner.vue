<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';

const storageKey = 'cookie_consent_status';
const showBanner = ref(false);
const consentStatus = ref<'accepted' | 'declined' | null>(null);

const getCookie = (name: string): string | null => {
    const cookieString = document.cookie;
    const cookieParts = cookieString.split('; ').map((cookie) => cookie.split('='));
    const found = cookieParts.find(([cookieName]) => cookieName === name);
    return found ? decodeURIComponent(found[1]) : null;
};

const readStatus = () => {
    const localValue = localStorage.getItem(storageKey);
    const cookieValue = getCookie(storageKey);

    const value = localValue || cookieValue;

    if (value === 'accepted' || value === 'declined') {
        consentStatus.value = value;
    } else {
        consentStatus.value = null;
    }
};

const setCookie = (name: string, value: string, days = 365) => {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${date.toUTCString()}; path=/; SameSite=Lax;`;
};

const setStatus = (status: 'accepted' | 'declined') => {
    consentStatus.value = status;
    localStorage.setItem(storageKey, status);
    setCookie(storageKey, status);
    showBanner.value = false;
};

onMounted(() => {
    readStatus();
    showBanner.value = consentStatus.value === null;
});

watch(consentStatus, (newValue) => {
    if (newValue !== null) {
        showBanner.value = false;
    }
});
</script>

<template>
    <div
        v-if="showBanner"
        class="fixed inset-x-0 bottom-0 z-50 m-4 rounded-xl border border-slate-300 bg-white p-4 shadow-lg dark:border-slate-700 dark:bg-slate-900"
    >
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                    Мы используем куки
                </h3>
                <p class="text-xs text-slate-600 dark:text-slate-300">
                    Сайт использует обязательные куки для работы, аналитику и персонализацию.
                    Вы можете принять или отклонить необязательные куки.
                </p>
                <p class="text-xs text-sky-600 dark:text-sky-400">
                    Подробнее в политике конфиденциальности.
                </p>
            </div>

            <div class="flex gap-2">
                <button
                    @click="setStatus('declined')"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    Отклонить
                </button>
                <button
                    @click="setStatus('accepted')"
                    class="rounded-lg bg-sky-600 px-3 py-2 text-xs font-medium text-white hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400"
                >
                    Принять
                </button>
            </div>
        </div>
    </div>
</template>
