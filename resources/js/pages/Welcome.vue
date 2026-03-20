<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { dashboard } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { computed, reactive, ref } from 'vue';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const state = reactive({
    groupUsername: '',
    keywords: '',
});

const normalizedGroupUsername = computed(() =>
    state.groupUsername.trim().replace(/^@+/, ''),
);

const keywordsList = computed(() =>
    state.keywords
        .split(/[\s,]+/g)
        .map((word) => word.trim())
        .filter(Boolean),
);

const canSubmit = computed(() => normalizedGroupUsername.value.length > 0);

const lastRequest = ref<string | null>(null);

function onSubmit() {
    lastRequest.value = JSON.stringify(
        {
            source: 'telegram',
            groupUsername: normalizedGroupUsername.value,
            keywords: keywordsList.value,
        },
        null,
        2,
    );
}
</script>

<template>
    <Head title="Telegram поиск">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-background text-foreground">
        <header class="border-b">
            <nav
                class="mx-auto flex h-14 max-w-4xl items-center justify-end gap-2 px-4"
            >
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium shadow-xs transition-colors hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:hover:bg-input/50"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Button
                        variant="ghost"
                        disabled
                        title="Скоро"
                        aria-disabled="true"
                    >
                        Log in
                    </Button>
                    <Button
                        v-if="canRegister"
                        variant="outline"
                        disabled
                        title="Скоро"
                        aria-disabled="true"
                    >
                        Register
                    </Button>
                </template>
            </nav>
        </header>

        <main class="mx-auto w-full max-w-4xl px-4 py-6">
            <div class="mb-4">
                <h1 class="text-2xl font-semibold tracking-tight">
                    Добро пожаловать
                </h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Поиск по Telegram: username группы + слова (опционально).
                </p>
            </div>

            <Card>
                <CardHeader class="pb-4">
                    <CardTitle>Поиск</CardTitle>
                    <CardDescription>
                        Источник: Telegram. Username можно вводить с
                        <span class="font-medium">@</span>.
                    </CardDescription>
                </CardHeader>

                <CardContent>
                    <form class="space-y-4" @submit.prevent="onSubmit">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="groupUsername"
                                    >Username группы</Label
                                >
                                <Input
                                    id="groupUsername"
                                    v-model="state.groupUsername"
                                    autocomplete="off"
                                    placeholder="@my_group или my_group"
                                />
                            </div>

                            <div class="space-y-2">
                                <Label for="keywords">Поиск по словам</Label>
                                <Input
                                    id="keywords"
                                    v-model="state.keywords"
                                    autocomplete="off"
                                    placeholder="доставка, скидка…"
                                />
                                <p class="text-xs text-muted-foreground">
                                    Слова через пробел или запятую.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div class="text-sm text-muted-foreground">
                                Группа:
                                <span class="font-medium">@</span
                                >{{ normalizedGroupUsername || '—' }}
                            </div>
                            <Button type="submit" :disabled="!canSubmit">
                                Искать
                            </Button>
                        </div>
                    </form>
                </CardContent>

                <CardFooter
                    v-if="lastRequest"
                    class="flex flex-col items-start gap-2"
                >
                    <div class="text-sm font-medium">Запрос (черновик)</div>
                    <pre
                        class="w-full overflow-auto rounded-md border border-input bg-background p-3 text-xs text-muted-foreground"
                    ><code>{{ lastRequest }}</code></pre>
                </CardFooter>
            </Card>
        </main>
    </div>
</template>
