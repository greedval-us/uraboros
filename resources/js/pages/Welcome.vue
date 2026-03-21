<script setup lang="ts">
import { Button } from '@/components/ui/button';
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

const features = [
    {
        title: 'Глубокая аналитика Telegram',
        description:
            'Динамика роста, вовлеченность, качество аудитории и ключевые точки просадки в одном месте.',
    },
    {
        title: 'Отчеты, которые можно отправлять клиентам',
        description:
            'Автоматическая сборка понятных отчетов по метрикам, чтобы быстро принимать решения по контенту и рекламе.',
    },
    {
        title: 'Платформа с заделом на масштаб',
        description:
            'Сейчас фокус на Telegram, в дальнейшем uraboros расширится на другие мессенджеры и каналы коммуникации.',
    },
];

const highlights = [
    { label: 'до 70%', value: 'сокращение времени на ручную аналитику' },
    { label: '24/7', value: 'доступ к свежим данным и отчетам' },
    { label: '1 экран', value: 'единая картина по ключевым метрикам' },
];
</script>

<template>
    <Head title="uraboros - Аналитика мессенджеров">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div class="landing min-h-screen text-slate-100">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="orb orb-one"></div>
            <div class="orb orb-two"></div>
        </div>

        <header class="relative z-10 border-b border-white/15">
            <nav
                class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4"
            >
                <div class="flex items-center gap-3">
                    <span
                        class="grid size-8 place-items-center rounded-lg bg-cyan-400/20 text-xs font-bold text-cyan-200"
                    >
                        U
                    </span>
                    <div>
                        <p
                            class="text-sm font-semibold tracking-[0.2em] uppercase"
                        >
                            uraboros
                        </p>
                        <p class="text-xs text-slate-300/80">
                            messenger analytics
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="inline-flex items-center rounded-md border border-cyan-200/40 px-4 py-2 text-sm font-medium transition hover:border-cyan-200 hover:bg-cyan-300/10"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="inline-flex items-center rounded-md border border-white/30 px-4 py-2 text-sm font-medium transition hover:bg-white/10"
                        >
                            Войти
                        </Link>
                        <Link v-if="canRegister" :href="register()">
                            <Button
                                class="bg-cyan-300 text-slate-900 hover:bg-cyan-200"
                            >
                                Регистрация
                            </Button>
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main class="relative z-10">
            <section
                class="mx-auto grid w-full max-w-6xl gap-10 px-4 pt-14 pb-14 md:grid-cols-[1.15fr_0.85fr] md:pt-20"
            >
                <div
                    class="animate-rise space-y-8"
                    style="animation-delay: 80ms"
                >
                    <p
                        class="inline-flex items-center rounded-full border border-cyan-200/35 bg-cyan-200/10 px-4 py-1 text-xs tracking-[0.18em] text-cyan-100 uppercase"
                    >
                        welcome to uraboros
                    </p>

                    <h1
                        class="max-w-2xl text-4xl leading-tight font-bold md:text-6xl"
                    >
                        Стартовая точка для аналитики Telegram сегодня и
                        мессенджеров завтра.
                    </h1>

                    <p class="max-w-xl text-base text-slate-200/85 md:text-lg">
                        uraboros помогает видеть, как растет аудитория, где
                        теряется внимание и какие темы реально двигают канал
                        вперед.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <Link v-if="$page.props.auth.user" :href="dashboard()">
                            <Button
                                class="h-11 bg-cyan-300 px-6 text-slate-900 hover:bg-cyan-200"
                            >
                                Открыть дашборд
                            </Button>
                        </Link>
                        <Link v-else :href="login()">
                            <Button
                                class="h-11 bg-cyan-300 px-6 text-slate-900 hover:bg-cyan-200"
                            >
                                Начать сейчас
                            </Button>
                        </Link>
                        <a
                            href="#features"
                            class="inline-flex h-11 items-center rounded-md border border-white/35 px-6 text-sm font-medium transition hover:bg-white/10"
                        >
                            Посмотреть возможности
                        </a>
                    </div>
                </div>

                <div
                    class="animate-rise grid gap-4 self-start rounded-2xl border border-white/15 bg-white/5 p-5 backdrop-blur-md"
                    style="animation-delay: 180ms"
                >
                    <h2
                        class="text-sm tracking-[0.16em] text-cyan-100/90 uppercase"
                    >
                        Почему uraboros
                    </h2>

                    <div class="space-y-3">
                        <article
                            v-for="(item, index) in highlights"
                            :key="item.label"
                            class="rounded-xl border border-white/15 bg-slate-950/30 p-4"
                            :style="{ animationDelay: `${220 + index * 80}ms` }"
                        >
                            <p class="text-2xl font-bold text-cyan-200">
                                {{ item.label }}
                            </p>
                            <p class="text-sm text-slate-200/80">
                                {{ item.value }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="features" class="mx-auto w-full max-w-6xl px-4 pb-16">
                <div class="animate-rise mb-8" style="animation-delay: 260ms">
                    <h2 class="text-3xl font-bold md:text-4xl">
                        Ключевые возможности
                    </h2>
                    <p class="mt-2 max-w-2xl text-slate-300/85">
                        Платформа создана для команд, которым нужна оперативная
                        и понятная аналитика без ручной рутины.
                    </p>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <article
                        v-for="(feature, index) in features"
                        :key="feature.title"
                        class="animate-rise rounded-2xl border border-white/15 bg-white/5 p-6 backdrop-blur-sm"
                        :style="{ animationDelay: `${320 + index * 100}ms` }"
                    >
                        <h3 class="text-lg font-semibold text-cyan-100">
                            {{ feature.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-relaxed text-slate-200/85"
                        >
                            {{ feature.description }}
                        </p>
                    </article>
                </div>
            </section>
        </main>
    </div>
</template>

<style scoped>
.landing {
    font-family: 'Space Grotesk', 'Segoe UI', sans-serif;
    position: relative;
    background:
        radial-gradient(
            circle at 15% 15%,
            rgb(8 145 178 / 0.32),
            transparent 40%
        ),
        radial-gradient(
            circle at 82% 14%,
            rgb(30 58 138 / 0.35),
            transparent 42%
        ),
        linear-gradient(140deg, #020617 0%, #0f172a 45%, #082f49 100%);
}

.orb {
    position: absolute;
    border-radius: 9999px;
    filter: blur(55px);
    opacity: 0.5;
    transform: translateZ(0);
}

.orb-one {
    background: #67e8f9;
    height: 260px;
    width: 260px;
    left: -80px;
    top: 60px;
    animation: floatOrb 7s ease-in-out infinite;
}

.orb-two {
    background: #38bdf8;
    height: 300px;
    width: 300px;
    right: -120px;
    bottom: 10%;
    animation: floatOrb 9s ease-in-out infinite reverse;
}

.animate-rise {
    opacity: 0;
    animation: riseIn 0.7s ease forwards;
}

@keyframes riseIn {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes floatOrb {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-12px);
    }
}
</style>
