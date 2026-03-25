<script setup lang="ts">
import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import { home, register } from "@/routes";
import { store } from "@/routes/login";
import { request } from "@/routes/password";
import { Form, Head, Link } from "@inertiajs/vue3";

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Вход - uraboros">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
        <link
            href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div class="auth-landing min-h-screen text-slate-100">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="orb orb-one"></div>
            <div class="orb orb-two"></div>
        </div>

        <div
            class="relative z-10 mx-auto grid min-h-screen w-full max-w-6xl px-4 py-8 lg:grid-cols-2 lg:gap-10 lg:py-12"
        >
            <section
                class="hidden flex-col justify-between rounded-3xl border border-white/15 bg-white/5 p-8 backdrop-blur-sm lg:flex"
            >
                <Link :href="home()" class="inline-flex items-center gap-3">
                    <span
                        class="grid size-9 place-items-center rounded-lg bg-cyan-400/20 text-xs font-bold text-cyan-200"
                    >
                        U
                    </span>
                    <div>
                        <p class="text-sm font-semibold tracking-[0.2em] uppercase">uraboros</p>
                        <p class="text-xs text-slate-300/80">messenger analytics</p>
                    </div>
                </Link>

                <div class="space-y-4">
                    <h1 class="text-4xl leading-tight font-bold">
                        Вход в аналитику, которая показывает реальную картину по Telegram.
                    </h1>
                    <p class="max-w-md text-slate-200/85">
                        Проверяйте динамику, отчеты и ключевые метрики в одном месте, без ручной
                        рутины.
                    </p>
                </div>

                <p class="text-xs text-slate-300/75">
                    Сейчас фокус на Telegram. Дальше добавим аналитику других мессенджеров.
                </p>
            </section>

            <section class="flex items-center justify-center">
                <div
                    class="w-full max-w-md rounded-3xl border border-white/15 bg-slate-950/50 p-6 backdrop-blur-md sm:p-8"
                >
                    <div class="mb-6 space-y-2">
                        <Link
                            :href="home()"
                            class="inline-flex items-center gap-2 text-cyan-100 lg:hidden"
                        >
                            <span
                                class="grid size-8 place-items-center rounded-lg bg-cyan-400/20 text-xs font-bold text-cyan-200"
                            >
                                U
                            </span>
                            <span class="text-xs font-semibold tracking-[0.2em] uppercase"
                                >uraboros</span
                            >
                        </Link>
                        <h2 class="text-2xl font-bold">Вход</h2>
                        <p class="text-sm text-slate-300/80">
                            Введите email и пароль, чтобы перейти в личный кабинет.
                        </p>
                    </div>

                    <div
                        v-if="status"
                        class="mb-4 rounded-md border border-emerald-300/40 bg-emerald-300/10 px-3 py-2 text-sm text-emerald-100"
                    >
                        {{ status }}
                    </div>

                    <Form
                        v-bind="store.form()"
                        :reset-on-success="['password']"
                        v-slot="{ errors, processing }"
                        class="flex flex-col gap-5"
                    >
                        <div class="grid gap-5">
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="email"
                                    placeholder="email@example.com"
                                    class="border-white/20 bg-white/5 text-slate-100 placeholder:text-slate-400"
                                />
                                <InputError :message="errors.email" />
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="password">Пароль</Label>
                                    <Link
                                        v-if="canResetPassword"
                                        :href="request()"
                                        class="text-xs text-cyan-200 transition hover:text-cyan-100"
                                        :tabindex="5"
                                    >
                                        Забыли пароль?
                                    </Link>
                                </div>
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    :tabindex="2"
                                    autocomplete="current-password"
                                    placeholder="Введите пароль"
                                    class="border-white/20 bg-white/5 text-slate-100 placeholder:text-slate-400"
                                />
                                <InputError :message="errors.password" />
                            </div>

                            <div class="flex items-center justify-between">
                                <Label for="remember" class="flex items-center space-x-3">
                                    <Checkbox id="remember" name="remember" :tabindex="3" />
                                    <span>Запомнить меня</span>
                                </Label>
                            </div>

                            <Button
                                type="submit"
                                class="h-11 w-full bg-cyan-300 text-slate-900 hover:bg-cyan-200"
                                :tabindex="4"
                                :disabled="processing"
                                data-test="login-button"
                            >
                                <Spinner v-if="processing" />
                                Войти
                            </Button>
                        </div>

                        <div class="text-center text-sm text-slate-300/80" v-if="canRegister">
                            Нет аккаунта?
                            <Link
                                :href="register()"
                                :tabindex="5"
                                class="text-cyan-200 transition hover:text-cyan-100"
                            >
                                Регистрация
                            </Link>
                        </div>
                    </Form>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>
.auth-landing {
    font-family: "Space Grotesk", "Segoe UI", sans-serif;
    position: relative;
    background:
        radial-gradient(circle at 12% 18%, rgb(8 145 178 / 0.3), transparent 40%),
        radial-gradient(circle at 85% 12%, rgb(30 58 138 / 0.35), transparent 44%),
        linear-gradient(140deg, #020617 0%, #0f172a 50%, #082f49 100%);
}

.orb {
    position: absolute;
    border-radius: 9999px;
    filter: blur(60px);
    opacity: 0.5;
}

.orb-one {
    background: #67e8f9;
    width: 260px;
    height: 260px;
    left: -80px;
    top: 50px;
}

.orb-two {
    background: #38bdf8;
    width: 300px;
    height: 300px;
    right: -120px;
    bottom: 8%;
}
</style>
