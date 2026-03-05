<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Project Analytics">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <!-- Навигация -->
        <header class="mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>

        <!-- Основной контент аналитики -->
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[335px] flex-col overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">

                <!-- Панель аналитики -->
                <div class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 shadow-md lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC]">
                    <h1 class="mb-4 text-xl font-bold">Project Analytics Dashboard</h1>
                    <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                        Monitor your project's key metrics and insights in real-time.
                    </p>

                    <!-- Пример статистики -->
                    <ul class="space-y-4">
                        <li class="flex justify-between border-b border-[#e3e3e0] pb-2 dark:border-[#3E3E3A]">
                            <span>Active Users</span>
                            <span class="font-medium">1,245</span>
                        </li>
                        <li class="flex justify-between border-b border-[#e3e3e0] pb-2 dark:border-[#3E3E3A]">
                            <span>Page Views</span>
                            <span class="font-medium">12,389</span>
                        </li>
                        <li class="flex justify-between border-b border-[#e3e3e0] pb-2 dark:border-[#3E3E3A]">
                            <span>New Signups</span>
                            <span class="font-medium">312</span>
                        </li>
                    </ul>

                    <!-- Место для графика/чартов -->
                    <div class="mt-8 h-48 w-full bg-[#f5f5f5] dark:bg-[#252524] rounded-lg flex items-center justify-center">
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">[Chart Placeholder]</span>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
