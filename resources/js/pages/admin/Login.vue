<template>
    <div
        class="flex min-h-screen items-center justify-center bg-[url('/bg-login.jpeg')] bg-cover bg-center px-6"
    >
        <div
            class="flex max-h-[600px] w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-lg"
        >
            <!-- KIRI: Form Login -->
            <div
                class="flex w-full flex-col justify-center p-8 lg:w-1/2 lg:p-12"
            >
                <div class="mb-6 text-center lg:text-left">
                    <h2
                        class="text-3xl font-extrabold text-[var(--dark-green)]"
                    >
                        Selamat Datang, Pustakawan
                    </h2>
                    <p class="mt-1 text-sm text-[var(--font-green)]">
                        Silakan masuk untuk mengelola sistem informasi
                        perpustakaan.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[var(--font-green)]"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            autocomplete="username"
                            placeholder="contoh@polban.ac.id"
                            class="focus:ring-opacity-50 w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                            :class="{ 'border-red-300': form.errors.email }"
                        />
                        <p
                            v-if="form.errors.email"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[var(--font-green)]"
                            >Kata Sandi</label
                        >
                        <div class="relative">
                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="focus:ring-opacity-50 w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                                :class="{
                                    'border-red-300': form.errors.password,
                                }"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute top-1/2 right-2 -translate-y-1/2 text-sm text-gray-600"
                            >
                                {{ showPassword ? 'Sembunyikan' : 'Tampilkan' }}
                            </button>
                        </div>
                        <p
                            v-if="form.errors.password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="rounded text-white/90"
                            />
                            <span class="ml-2 text-[var(--font-green)]"
                                >Ingat saya</span
                            >
                        </label>
                    </div>

                    <div>
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="w-full rounded-md py-2 font-medium text-white transition-colors"
                            :style="{
                                background: form.processing
                                    ? 'rgba(17,186,130,0.7)'
                                    : 'var(--primary-green)',
                            }"
                        >
                            <span v-if="form.processing">Memproses...</span>
                            <span v-else>Masuk</span>
                        </button>
                        <p
                            v-if="generalError"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ generalError }}
                        </p>
                    </div>
                </form>

                <p class="mt-6 text-center text-xs text-[var(--font-green)]">
                    Hanya akun admin yang dapat masuk ke sistem ini.
                </p>
            </div>

            <!-- KANAN: Ilustrasi -->
            <div
                class="bg-opacity-10 hidden w-1/2 items-center justify-center bg-[var(--background-green)] lg:flex"
            >
                <img src="/bookshelf.png" alt="" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const page = usePage();

const generalError = computed(() => {
    return page.props.value?.flash?.error || '';
});

function submit() {
    form.post('/admin/login', {
        onError() {},
        onFinish() {},
    });
}
</script>

<style scoped>
:root {
    --dark-green: rgb(6, 84, 63);
    --font-green: rgb(4, 120, 87);
    --primary-green: rgb(17, 186, 130);
    --background-green: rgb(245, 255, 250);
}

input:focus {
    box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.06);
    border-color: var(--font-green);
}
button:disabled {
    cursor: not-allowed;
    opacity: 0.9;
}
</style>
