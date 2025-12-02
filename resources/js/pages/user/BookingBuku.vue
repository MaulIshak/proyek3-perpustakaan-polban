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
    AlertCircle, // Icon Error
    Check,       // Icon Sukses
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

// --- STATE VALIDASI LANJUTAN ---
// Struktur: { isValid: boolean, message: string }
const validation = reactive({
    nimNip: { isValid: false, message: '' },
    whatsapp: { isValid: false, message: '' }
});

// --- LOGIKA VALIDASI NIM / NIP ---
const validateNim = (event: Event) => {
    const input = (event.target as HTMLInputElement).value;
    form.nimNip = input; // Update form manual

    // 1. Cek Karakter Aneh (Huruf/Simbol)
    if (/[^0-9]/.test(input)) {
        validation.nimNip.isValid = false;
        validation.nimNip.message = "Hanya boleh angka (0-9). Huruf/Simbol tidak diizinkan.";
        return;
    }

    // 2. Cek Panjang Karakter (Aturan: 9-10 Digit)
    if (input.length > 0 && input.length < 9) {
        validation.nimNip.isValid = false;
        validation.nimNip.message = `Terlalu pendek (${input.length} digit). Minimal 9 digit.`;
    } else if (input.length > 10) {
        validation.nimNip.isValid = false;
        validation.nimNip.message = `Terlalu panjang (${input.length} digit). Maksimal 10 digit.`;
    } else if (input.length === 0) {
        validation.nimNip.isValid = false;
        validation.nimNip.message = ""; // Kosong biarkan default required
    } else {
        // 3. SUKSES
        validation.nimNip.isValid = true;
        validation.nimNip.message = "Format Valid (9-10 Digit).";
    }
};

// --- LOGIKA VALIDASI WHATSAPP ---
const validateWa = (event: Event) => {
    const input = (event.target as HTMLInputElement).value;
    form.whatsapp = input;

    // 1. Cek Karakter Aneh
    if (/[^0-9]/.test(input)) {
        validation.whatsapp.isValid = false;
        validation.whatsapp.message = "Nomor HP hanya boleh angka.";
        return;
    }

    // 2. Cek Panjang (Aturan: 10-15 Digit)
    if (input.length > 0 && input.length < 10) {
        validation.whatsapp.isValid = false;
        validation.whatsapp.message = `Nomor terlalu pendek (${input.length} digit). Minimal 10 digit.`;
    } else if (input.length > 15) {
        validation.whatsapp.isValid = false;
        validation.whatsapp.message = `Nomor terlalu panjang (${input.length} digit). Maksimal 15 digit.`;
    } else if (input.length === 0) {
        validation.whatsapp.isValid = false;
        validation.whatsapp.message = "";
    } else {
        // 3. SUKSES
        validation.whatsapp.isValid = true;
        validation.whatsapp.message = "Format Valid.";
    }
};

// Cek apakah tombol submit boleh nyala
const isFormInvalid = computed(() => {
    // Tombol mati jika: Sedang loading ATAU NIM Salah ATAU WA Salah
    return form.processing || 
           (form.nimNip.length > 0 && !validation.nimNip.isValid) || 
           (form.whatsapp.length > 0 && !validation.whatsapp.isValid);
});

const submitForm = () => {
    // Final check
    if (!validation.nimNip.isValid || !validation.whatsapp.isValid) return;

    form.post('/book-reservation', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset();
            // Reset validasi visual
            validation.nimNip = { isValid: false, message: '' };
            validation.whatsapp = { isValid: false, message: '' };
            
            setTimeout(() => {
                messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        },
        onError: (err) => { console.error(err); }
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
            
            <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 -translate-y-4" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
                <div v-if="showMessage" ref="messageRef" class="mx-auto mb-8 flex max-w-4xl items-start gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-lg">
                    <div class="shrink-0 rounded-full bg-emerald-100 p-2 text-emerald-600"><CheckCircle2 class="h-8 w-8" /></div>
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-emerald-800">Booking Berhasil! 📚</h3>
                        <p class="leading-relaxed text-emerald-700">Permintaan booking Anda telah dicatat. Cek email/WhatsApp untuk info selanjutnya.</p>
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
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><User class="h-5 w-5" /></div>
                                        <input v-model="form.namaLengkap" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan nama lengkap sesuai KTM" required />
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">NIM / NIP <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 transition-colors" 
                                             :class="validation.nimNip.message && !validation.nimNip.isValid ? 'text-red-400' : (validation.nimNip.isValid ? 'text-green-500' : 'text-slate-400')">
                                            <Hash class="h-5 w-5" />
                                        </div>
                                        
                                        <input 
                                            :value="form.nimNip"
                                            @input="validateNim"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="[
                                                validation.nimNip.isValid 
                                                    ? 'border-green-500 focus:border-green-500 focus:ring-green-500/20 text-green-700' 
                                                    : (validation.nimNip.message ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20')
                                            ]"
                                            placeholder="Contoh: 211511001" required inputmode="numeric" 
                                        />

                                        <div v-if="form.nimNip.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="validation.nimNip.isValid" class="h-5 w-5 text-green-500" />
                                            <AlertCircle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>
                                    
                                    <p v-if="validation.nimNip.message" 
                                       class="mt-2 text-xs font-medium flex items-center gap-1"
                                       :class="validation.nimNip.isValid ? 'text-green-600' : 'text-red-500'">
                                        {{ validation.nimNip.message }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">WhatsApp (Aktif) <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 transition-colors"
                                             :class="validation.whatsapp.message && !validation.whatsapp.isValid ? 'text-red-400' : (validation.whatsapp.isValid ? 'text-green-500' : 'text-slate-400')">
                                            <MessageCircle class="h-5 w-5" />
                                        </div>
                                        
                                        <input 
                                            :value="form.whatsapp"
                                            @input="validateWa"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="[
                                                validation.whatsapp.isValid 
                                                    ? 'border-green-500 focus:border-green-500 focus:ring-green-500/20 text-green-700' 
                                                    : (validation.whatsapp.message ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20')
                                            ]"
                                            placeholder="Contoh: 081234567890" required inputmode="numeric" 
                                        />

                                        <div v-if="form.whatsapp.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="validation.whatsapp.isValid" class="h-5 w-5 text-green-500" />
                                            <AlertCircle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>

                                    <p v-if="validation.whatsapp.message" 
                                       class="mt-2 text-xs font-medium flex items-center gap-1"
                                       :class="validation.whatsapp.isValid ? 'text-green-600' : 'text-red-500'">
                                        {{ validation.whatsapp.message }}
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><Mail class="h-5 w-5" /></div>
                                        <input v-model="form.email" type="email" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="email@polban.ac.id" required />
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
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><BookOpen class="h-5 w-5" /></div>
                                        <input v-model="form.judulBuku" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan judul buku lengkap" required />
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><PenTool class="h-5 w-5" /></div>
                                        <input v-model="form.pengarang" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Nama pengarang" required />
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
                            
                            <transition enter-active-class="transition-all duration-300" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition-all duration-200" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
                                <p v-if="(!validation.nimNip.isValid && form.nimNip.length > 0) || (!validation.whatsapp.isValid && form.whatsapp.length > 0)" class="mt-4 text-center text-sm text-red-500 font-medium">
                                    Formulir belum bisa dikirim. Mohon perbaiki kolom yang berwarna merah.
                                </p>
                            </transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>