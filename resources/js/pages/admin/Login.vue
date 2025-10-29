<template>
    <div
        class="flex min-h-screen items-center justify-center"
        :style="{ background: 'var(--background-green)' }"
    >
        <div class="w-full max-w-md px-6 py-8">
            <div
                class="overflow-hidden rounded-xl bg-white p-6 shadow-md"
                style="border-radius: 12px"
            >
                <h1
                    class="mb-1 text-2xl font-semibold"
                    style="color: var(--dark-green)"
                >
                    Admin Login
                </h1>
                <p class="mb-6 text-sm" style="color: var(--font-green)">
                    Please sign in with your administrator account.
                </p>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium"
                            style="color: var(--font-green)"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            autocomplete="username"
                            class="focus:ring-opacity-50 w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                            :class="{ 'border-red-300': form.errors.email }"
                            placeholder="you@example.com"
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
                            class="mb-1 block text-sm font-medium"
                            style="color: var(--font-green)"
                            >Password</label
                        >
                        <div class="relative">
                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                class="focus:ring-opacity-50 w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                                :class="{
                                    'border-red-300': form.errors.password,
                                }"
                                placeholder="Your password"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute top-1/2 right-2 -translate-y-1/2 text-sm text-gray-600"
                            >
                                {{ showPassword ? 'Hide' : 'Show' }}
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
                            <span class="ml-2" style="color: var(--font-green)"
                                >Remember me</span
                            >
                        </label>
                        <a
                            href="#"
                            class="text-sm underline"
                            style="color: var(--font-green)"
                            >Forgot password?</a
                        >
                    </div>

                    <div>
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="w-full rounded-md py-2 font-medium text-white"
                            :style="{
                                background: form.processing
                                    ? 'rgba(17,186,130,0.7)'
                                    : 'var(--primary-green)',
                            }"
                        >
                            <span v-if="form.processing">Signing in...</span>
                            <span v-else>Sign in</span>
                        </button>
                        <p
                            v-if="generalError"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ generalError }}
                        </p>
                    </div>
                </form>

                <p
                    class="mt-6 text-center text-xs"
                    style="color: var(--font-green)"
                >
                    Only administrators can login here
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// toggle for password visibility
const showPassword = ref(false);

// Inertia form state
const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const page = usePage();

// general error from flash (e.g., invalid credentials) or set via onError
const generalError = computed(() => {
    // flash messages from backend (Laravel) are available at page.props.value.flash
    return page.props.value?.flash?.error || '';
});

function submit() {
    // send POST to admin login endpoint
    form.post('/admin/login', {
        onError(errors) {
            // leave field errors to form.errors; non-field errors may be in flash which we read from page.props
        },
        onFinish() {
            // you can add tracking or cleanup here
        },
    });
}
</script>

<style scoped>
:root {
    --dark-green: rgb(6, 84, 63);
    --font-green: rgb(4, 120, 87);
    --primary-green: rgb(17, 186, 130);
    --background-green: rgb(245, 255, 250);
    --font-light-green: rgb(210, 250, 229);
}

/* minimal style adjustments to match design intent; Tailwind handles responsive layout */
input:focus {
    box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.06);
    border-color: var(--font-green);
}
button:disabled {
    cursor: not-allowed;
    opacity: 0.9;
}
</style>
