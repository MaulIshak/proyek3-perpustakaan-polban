<script setup lang="ts">
import { onMounted, ref } from 'vue';

const isMounted = ref(false);

onMounted(() => {
    setTimeout(() => {
        isMounted.value = true;
    }, 100);
});
</script>

<template>
    <section
        class="relative w-full bg-cover bg-center bg-no-repeat text-white transition-all duration-1000 md:bg-[center_85%]"
        :style="{ backgroundImage: `url('/hero-bg.jpg')` }"
    >
        <div
            class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/40 to-slate-900/70"
        ></div>

        <div
            class="relative z-10 mx-auto max-w-7xl px-6 py-32 text-left md:py-48 md:text-center lg:px-8"
        >
            <div
                class="transition-all duration-700 ease-out"
                :class="
                    isMounted
                        ? 'translate-y-0 opacity-100'
                        : 'translate-y-8 opacity-0'
                "
            >
                <h2
                    class="mb-3 text-2xl font-extrabold tracking-tight text-slate-200 drop-shadow-md md:mb-4 md:text-5xl"
                >
                    Selamat Datang di
                </h2>
            </div>

            <div
                class="transition-all delay-200 duration-700 ease-out"
                :class="
                    isMounted
                        ? 'translate-y-0 opacity-100'
                        : 'translate-y-8 opacity-0'
                "
            >
                <h1
                    class="mb-6 bg-gradient-to-r from-[#bef264] via-[#99cc33] to-emerald-400 bg-clip-text text-4xl leading-tight font-bold text-transparent drop-shadow-lg md:text-6xl md:leading-normal"
                >
                    PERPUSTAKAAN POLBAN
                </h1>
            </div>

            <div
                class="transition-all delay-500 duration-700 ease-out"
                :class="
                    isMounted ? 'scale-100 opacity-100' : 'scale-x-0 opacity-0'
                "
            >
                <div
                    class="h-2 w-24 rounded-full bg-[#99cc33] md:mx-auto md:w-36"
                ></div>
            </div>
        </div>
    </section>
</template>
