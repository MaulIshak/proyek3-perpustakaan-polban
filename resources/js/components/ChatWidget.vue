<script setup lang="ts">
import {
    CheckCircle2,
    Loader2, // Import icon loading
    Mail,
    MessageCircle,
    MessageSquare,
    Send,
    User,
    X,
} from 'lucide-vue-next';
import { ref, computed } from 'vue'; // Tambahkan computed

const isOpen = ref(false);
const isSent = ref(false);
const isLoading = ref(false); // State untuk loading

const formData = ref({
    nama: '',
    email: '',
    pertanyaan: '',
});

// --- LOGIC VALIDASI REALTIME ---
// Menggunakan computed agar reaktif. Tombol akan otomatis disable jika ini false.
const isFormValid = computed(() => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return (
        formData.value.nama.trim() !== '' &&
        emailRegex.test(formData.value.email) &&
        formData.value.pertanyaan.trim() !== ''
    );
});

const handleSubmit = async (e: Event) => {
    // Prevent default tetap perlu, tapi kita handle validasi via button state juga
    if (!isFormValid.value || isLoading.value) return;

    isLoading.value = true; // Mulai Loading

    try {
        const csrfElement = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;
        const csrfToken = csrfElement ? csrfElement.content : '';

        const res = await fetch('/send-question', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(formData.value)
        });

        const data = await res.json().catch(() => null);

        if (!res.ok) {
            if (res.status === 422 && data?.errors) {
                const errorMessages = Object.values(data.errors).flat().join('\n');
                throw new Error(errorMessages);
            }
            throw new Error(data?.message || `Server Error: ${res.status}`);
        }

        isSent.value = true;

    } catch (err) {
        console.error("Gagal mengirim:", err);
        alert(err instanceof Error ? err.message : "Terjadi kesalahan jaringan.");
    } finally {
        // --- KRUSIAL: Matikan loading apapun yang terjadi (sukses/error) ---
        isLoading.value = false;
    }
};

const resetChat = () => {
    isOpen.value = false;
    setTimeout(() => {
        isSent.value = false;
        // Reset form
        formData.value = { nama: '', email: '', pertanyaan: '' };
    }, 300);
};
</script>

<template>
    <div>
        <transition name="fade">
            <div
                v-if="isOpen"
                class="fixed inset-0 z-40 bg-black/20 sm:hidden"
                @click="isOpen = false"
            ></div>
        </transition>

        <transition name="scale">
            <div
                v-if="!isOpen"
                class="fixed right-6 bottom-6 z-50 flex items-center gap-3"
            >
                <span
                    class="hidden rounded-lg border border-slate-100 bg-white px-3 py-1.5 text-xs font-bold whitespace-nowrap text-slate-700 shadow-md transition-all duration-300 sm:block"
                >
                    Tanya Pustakawan
                </span>

                <button
                    @click="isOpen = true"
                    class="group flex h-16 w-16 items-center justify-center rounded-full bg-[#99cc33] text-white shadow-lg shadow-[#99cc33]/40 transition-all duration-300 hover:scale-110 hover:bg-[#88b82d] focus:ring-4 focus:ring-[#99cc33]/30 focus:outline-none"
                    aria-label="Buka Chat Pustakawan"
                >
                    <MessageCircle
                        class="h-8 w-8 transition-transform group-hover:-rotate-12"
                    />
                </button>
            </div>
        </transition>

        <transition name="slide-up">
            <div
                v-if="isOpen"
                class="fixed right-6 bottom-6 z-50 flex max-h-[80vh] w-full max-w-[calc(100vw-3rem)] flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-2xl shadow-slate-300/50 sm:w-[400px]"
            >
                <div
                    class="flex shrink-0 items-center justify-between bg-[#99cc33] p-5"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full border border-white/30 bg-white/20"
                        >
                            <MessageCircle class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <h3
                                class="text-lg leading-tight font-bold text-white"
                            >
                                Pustakawan
                            </h3>
                            <p class="mt-0.5 text-xs font-medium text-white/90">
                                Kami siap membantu
                            </p>
                        </div>
                    </div>
                    <button
                        @click="resetChat"
                        class="rounded-full p-2 text-white/80 transition-all hover:bg-white/20 hover:text-white"
                    >
                        <X class="h-6 w-6" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto bg-slate-50 p-6">
                    <form
                        v-if="!isSent"
                        @submit.prevent="handleSubmit"
                        class="space-y-5"
                    >
                        <p
                            class="mb-6 rounded-xl rounded-tl-none border border-slate-100 bg-white p-4 text-sm leading-relaxed text-slate-600 shadow-sm"
                        >
                            Halo! 👋 Ada yang bisa kami bantu mengenai layanan
                            perpustakaan? Silakan isi form di bawah ini.
                        </p>

                        <div class="space-y-4">
                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"
                                >
                                    <User class="h-4 w-4" />
                                </div>
                                <input
                                    type="text"
                                    v-model="formData.nama"
                                    placeholder="Nama Lengkap"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pr-4 pl-10 text-sm text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                />
                            </div>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"
                                >
                                    <Mail class="h-4 w-4" />
                                </div>
                                <input
                                    type="email"
                                    v-model="formData.email"
                                    placeholder="Email (@polban.ac.id)"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pr-4 pl-10 text-sm text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                />
                            </div>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute top-3.5 left-3.5 flex items-start text-slate-400"
                                >
                                    <MessageSquare class="h-4 w-4" />
                                </div>
                                <textarea
                                    v-model="formData.pertanyaan"
                                    placeholder="Tulis pertanyaan Anda..."
                                    required
                                    rows="3"
                                    class="w-full resize-none rounded-xl border border-slate-200 bg-white py-3 pr-4 pl-10 text-sm text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                ></textarea>
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="!isFormValid || isLoading"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-3.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all
                            hover:bg-[#88b82d] active:scale-95
                            disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none disabled:active:scale-100"
                        >
                            <template v-if="isLoading">
                                <Loader2 class="h-4 w-4 animate-spin" />
                                Mengirim...
                            </template>

                            <template v-else>
                                <Send class="h-4 w-4" />
                                Kirim Pertanyaan
                            </template>
                        </button>
                    </form>

                    <div
                        v-else
                        class="animate-fade-in flex h-full flex-col items-center justify-center py-8 text-center"
                    >
                        <div
                            class="animate-bounce-subtle mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100"
                        >
                            <CheckCircle2 class="h-10 w-10 text-emerald-600" />
                        </div>
                        <h4 class="mb-2 text-xl font-bold text-slate-800">
                            Pesan Terkirim!
                        </h4>
                        <p
                            class="mb-6 max-w-[250px] text-sm leading-relaxed text-slate-500"
                        >
                            Terima kasih, <strong>{{ formData.nama }}</strong>. Tim kami akan segera membalas ke email
                            <strong>{{ formData.email }}</strong>.
                        </p>
                        <button
                            @click="
                                isSent = false;
                                formData = {
                                    nama: '',
                                    email: '',
                                    pertanyaan: '',
                                };
                            "
                            class="text-sm font-bold text-[#99cc33] hover:underline"
                        >
                            Kirim pertanyaan lain
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
/* Animasi Masuk/Keluar Widget */
.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-up-enter-from,
.slide-up-leave-to {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
}

/* Animasi Scale Button */
.scale-enter-active,
.scale-leave-active {
    transition: all 0.3s ease;
}

.scale-enter-from,
.scale-leave-to {
    opacity: 0;
    transform: scale(0);
}

/* Animasi Fade Overlay */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes bounce-subtle {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}
.animate-bounce-subtle {
    animation: bounce-subtle 2s infinite;
}
</style>
