<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import {
    BookOpen,
    CalendarCheck,
    CheckCircle2,
    Hash,
    Mail,
    MessageCircle,
    PenTool,
    User,
    AlertTriangle // Icon peringatan
} from 'lucide-vue-next';
import { ref, reactive, computed } from 'vue';

defineProps<{
    title: string;
}>();

const breadcrumb = [{ label: 'Home', link: '/' }, { label: 'Booking Buku' }];

const form = useForm({
    namaLengkap: '',
    nimNip: '',
    email: '',
    whatsapp: '',
    judulBuku: '',
    pengarang: '',
});

const showMessage = ref(false);
const messageRef = ref<HTMLElement | null>(null);

// --- STATE VALIDASI ---
// Menyimpan pesan error spesifik untuk setiap field
const errors = reactive({
    nimNip: null as string | null,
    whatsapp: null as string | null
});

// --- LOGIKA VALIDASI "ALLOW BUT WARN" ---
const validateInput = (field: 'nimNip' | 'whatsapp') => {
    const value = form[field];
    
    // Reset error dulu
    errors[field] = null;

    if (!value) return; // Jika kosong, biarkan (required html yg handle)

    // Cek apakah mengandung karakter SELAIN angka
    // Regex /[^0-9]/ artinya: cari karakter yang BUKAN 0-9
    if (/[^0-9]/.test(value)) {
        // Cek spesifik apakah huruf atau simbol (untuk pesan yang lebih detail)
        if (/[a-zA-Z]/.test(value)) {
            errors[field] = "Terdeteksi huruf. Kolom ini hanya boleh diisi angka.";
        } else {
            errors[field] = "Simbol tidak diizinkan. Masukkan angka saja (0-9).";
        }
    }
};

// Computed property untuk cek apakah form valid untuk disubmit
const isFormInvalid = computed(() => {
    return form.processing || errors.nimNip !== null || errors.whatsapp !== null;
});

const submitForm = () => {
    // Double check sebelum kirim
    if (errors.nimNip || errors.whatsapp) return;

    form.post('/book-reservation', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset();
            errors.nimNip = null;
            errors.whatsapp = null;
            
            setTimeout(() => {
                messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        },
        onError: (err) => {
            console.error("Gagal submit:", err);
        }
    });
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div v-if="showMessage" ref="messageRef" class="mx-auto mb-8 flex max-w-4xl items-start gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-lg">
                    <div class="shrink-0 rounded-full bg-emerald-100 p-2 text-emerald-600">
                        <CheckCircle2 class="h-8 w-8" />
                    </div>
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-emerald-800">Booking Berhasil! 📚</h3>
                        <p class="leading-relaxed text-emerald-700">
                            Permintaan booking Anda telah dicatat. Kami akan menghubungi Anda melalui WhatsApp/Email segera setelah buku tersedia.
                        </p>
                    </div>
                </div>
            </transition>

            <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
                <div class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[var(--dark-green)]"></div>

                <div class="p-8 sm:p-10">
                    <form @submit.prevent="submitForm" class="space-y-10">
                        
                        <div>
                            <h3 class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800">
                                <User class="h-5 w-5 text-[#99cc33]" /> Data Peminjam
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <User class="h-5 w-5" />
                                        </div>
                                        <input v-model="form.namaLengkap" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan nama lengkap sesuai KTM" required />
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        NIM / NIP <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition-colors" :class="{'text-red-400': errors.nimNip}">
                                            <Hash class="h-5 w-5" />
                                        </div>
                                        <input 
                                            v-model="form.nimNip"
                                            @input="validateInput('nimNip')"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:ring-2"
                                            :class="errors.nimNip 
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' 
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Contoh: 211511001" 
                                            required 
                                        />
                                        
                                        <div v-if="errors.nimNip" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <AlertTriangle class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>
                                    
                                    <transition
                                        enter-active-class="transition-all duration-300 ease-out"
                                        enter-from-class="opacity-0 -translate-y-2 max-h-0"
                                        enter-to-class="opacity-100 translate-y-0 max-h-10"
                                        leave-active-class="transition-all duration-200 ease-in"
                                        leave-from-class="opacity-100 translate-y-0 max-h-10"
                                        leave-to-class="opacity-0 -translate-y-2 max-h-0"
                                    >
                                        <div v-if="errors.nimNip" class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1 overflow-hidden">
                                            {{ errors.nimNip }}
                                        </div>
                                    </transition>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        WhatsApp (Aktif) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition-colors" :class="{'text-red-400': errors.whatsapp}">
                                            <MessageCircle class="h-5 w-5" />
                                        </div>
                                        <input 
                                            v-model="form.whatsapp"
                                            @input="validateInput('whatsapp')"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:ring-2"
                                            :class="errors.whatsapp 
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' 
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Contoh: 081234567890" 
                                            required 
                                        />
                                        <div v-if="errors.whatsapp" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <AlertTriangle class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>

                                    <transition
                                        enter-active-class="transition-all duration-300 ease-out"
                                        enter-from-class="opacity-0 -translate-y-2 max-h-0"
                                        enter-to-class="opacity-100 translate-y-0 max-h-10"
                                        leave-active-class="transition-all duration-200 ease-in"
                                        leave-from-class="opacity-100 translate-y-0 max-h-10"
                                        leave-to-class="opacity-0 -translate-y-2 max-h-0"
                                    >
                                        <div v-if="errors.whatsapp" class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1 overflow-hidden">
                                            {{ errors.whatsapp }}
                                        </div>
                                    </transition>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <Mail class="h-5 w-5" />
                                        </div>
                                        <input v-model="form.email" type="email" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="email@polban.ac.id" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800">
                                <BookOpen class="h-5 w-5 text-[#99cc33]" /> Buku yang Dipesan
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <BookOpen class="h-5 w-5" />
                                        </div>
                                        <input v-model="form.judulBuku" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan judul buku lengkap" required />
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <PenTool class="h-5 w-5" />
                                        </div>
                                        <input v-model="form.pengarang" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Nama pengarang" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button 
                                type="submit" 
                                :disabled="isFormInvalid" 
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-4 text-lg font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/50 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none disabled:transform-none disabled:bg-slate-400"
                            >
                                <CalendarCheck v-if="!form.processing" class="h-5 w-5" />
                                <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ form.processing ? 'Mengirim...' : 'Kirim Permintaan Booking' }}
                            </button>

                            <transition
                                enter-active-class="transition-all duration-300"
                                enter-from-class="opacity-0 translate-y-2"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition-all duration-200"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-2"
                            >
                                <p v-if="errors.nimNip || errors.whatsapp" class="mt-4 text-center text-sm text-red-500 font-medium">
                                    Harap perbaiki data yang ditandai merah sebelum mengirim.
                                </p>
                                <p v-else class="mt-4 text-center text-sm text-slate-400">
                                    Pastikan data yang Anda masukkan valid agar kami dapat menghubungi Anda.
                                </p>
                            </transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>