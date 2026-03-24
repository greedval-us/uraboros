<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 64 64"
        :class="className"
        v-bind="$attrs"
    >
        <circle
            cx="32"
            cy="32"
            r="19.5"
            fill="none"
            stroke="#67e8f9"
            stroke-width="5.4"
            stroke-linecap="round"
            stroke-dasharray="112 20"
            stroke-dashoffset="10"
            opacity="0.95"
        />

        <circle cx="46.2" cy="20.2" r="4.2" fill="#38bdf8" />
        <circle cx="47.2" cy="19.4" r="0.9" fill="#020617" opacity="0.85" />
    </svg>
</template>
