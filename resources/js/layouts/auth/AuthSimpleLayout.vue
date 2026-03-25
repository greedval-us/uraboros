<script setup lang="ts">
import AppLogoIcon from "@/components/AppLogoIcon.vue";
import { home } from "@/routes";
import { Link } from "@inertiajs/vue3";

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="welkome-shell flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10"
    >
        <div class="welkome-orb welkome-orb-one"></div>
        <div class="welkome-orb welkome-orb-two"></div>

        <div class="w-full max-w-sm">
            <div class="glass-panel rounded-3xl p-6 sm:p-8">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col items-center gap-4">
                        <Link :href="home()" class="flex flex-col items-center gap-2 font-medium">
                            <div
                                class="mb-1 flex h-9 w-9 items-center justify-center rounded-md border border-cyan-200/35 bg-cyan-400/20"
                            >
                                <AppLogoIcon class="size-9 fill-current text-cyan-100" />
                            </div>
                            <span class="sr-only">{{ title }}</span>
                        </Link>
                        <div class="space-y-2 text-center">
                            <h1 class="text-xl font-medium">{{ title }}</h1>
                            <p class="text-center text-sm text-muted-foreground">
                                {{ description }}
                            </p>
                        </div>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
