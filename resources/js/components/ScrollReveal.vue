<script setup lang="ts">
import { cn } from '@/lib/utils';
import { useIntersectionObserver } from '@vueuse/core';
import { computed, ref } from 'vue';

interface Props {
    class?: string;
    animation?: 'fade-up' | 'fade-in' | 'slide-left' | 'zoom-in';
    duration?: number;
    delay?: number;
    threshold?: number;
    once?: boolean; // Jika true, animasi hanya jalan sekali (better performance)
}

const props = withDefaults(defineProps<Props>(), {
    animation: 'fade-up',
    duration: 700,
    delay: 0,
    threshold: 0.1,
    once: true,
});

const target = ref(null);
const isVisible = ref(false);

useIntersectionObserver(
    target,
    ([{ isIntersecting }]) => {
        if (props.once) {
            if (isIntersecting) isVisible.value = true;
        } else {
            isVisible.value = isIntersecting;
        }
    },
    { threshold: props.threshold },
);

// Definisi Style Animasi (Menggunakan CSS Transform untuk performa GPU)
const animationClasses = {
    'fade-up': 'translate-y-10 opacity-0',
    'fade-in': 'opacity-0',
    'slide-left': '-translate-x-10 opacity-0',
    'zoom-in': 'scale-95 opacity-0',
};

const activeClass = computed(() => {
    return isVisible.value
        ? 'translate-y-0 translate-x-0 scale-100 opacity-100'
        : animationClasses[props.animation];
});
</script>

<template>
    <div
        ref="target"
        :class="
            cn(
                'transition-all ease-out will-change-[transform,opacity]', // Hardware acceleration hint
                activeClass,
                props.class,
            )
        "
        :style="{
            transitionDuration: `${duration}ms`,
            transitionDelay: `${delay}ms`,
        }"
    >
        <slot />
    </div>
</template>
