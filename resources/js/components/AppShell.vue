<script setup lang="ts">
import CookieConsentBanner from "@/components/CookieConsentBanner.vue";
import { SidebarProvider } from "@/components/ui/sidebar";
import { usePage } from "@inertiajs/vue3";

interface Props {
    variant?: "header" | "sidebar";
}

defineProps<Props>();

const isOpen = usePage().props.sidebarOpen;
</script>

<template>
    <div v-if="variant === 'header'" class="welkome-shell flex min-h-screen w-full flex-col">
        <div class="welkome-orb welkome-orb-one"></div>
        <div class="welkome-orb welkome-orb-two"></div>
        <slot />
        <CookieConsentBanner />
    </div>
    <div v-else class="welkome-shell min-h-screen">
        <div class="welkome-orb welkome-orb-one"></div>
        <div class="welkome-orb welkome-orb-two"></div>
        <SidebarProvider :default-open="isOpen">
            <slot />
        </SidebarProvider>
        <CookieConsentBanner />
    </div>
</template>
