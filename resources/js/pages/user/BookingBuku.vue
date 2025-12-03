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
    AlertTriangle,
    Check
} from 'lucide-vue-next';
import { ref, reactive } from 'vue';

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
const formError = ref(''); // Pesan error global

// --- STATE VALIDASI ---
const errors = reactive({
    nimNip: null as string | null,
    whatsapp: null as string | null
});

// --- VALIDASI NIM / NIP ---
const validateNim = (value: string) => {
    if (!value) return "Wajib diisi.";
    if (/[^0-9]/.test(value)) return "Hanya boleh angka (0-9).";
    if (value.length < 9) return `Kurang (${value.length}/9 digit).`;
    if (value.length > 10) return `Lebih (${value.length}/10 digit).`;
    return null; // Valid
};

// --- VALIDASI WHATSAPP ---
const validateWa = (value: string) => {
    if (!value) return "Wajib diisi.";
    if (/[^0-9]/.test(value)) return "Nomor HP hanya boleh angka.";
    if (value.length < 10) return `Kurang (${value.length}/10 digit).`;
    if (value.length > 15) return `Lebih (${value.length}/15 digit).`;
    return null; // Valid
};

// --- HANDLER INPUT ---
const handleNimInput = (event: Event) => {
    const val = (event.target as HTMLInputElement).value;
    form.nimNip = val;
    // Validasi real-time hanya untuk visual, tidak memblokir tombol
    errors.nimNip = validateNim(val);
    formError.value = ''; // Reset pesan error global
};

const handleWaInput = (event: Event) => {
    const val = (event.target as HTMLInputElement).value;
    form.whatsapp = val;
    errors.whatsapp = validateWa(val);
    formError.value = '';
};

// --- SUBMIT FORM ---
const submitForm = () => {
    // 1. Lakukan Validasi Menyeluruh Saat Tombol Ditekan
    const nimError = validateNim(form.nimNip);
    const waError = validateWa(form.whatsapp);

    // Update state error agar muncul di input field
    errors.nimNip = nimError;
    errors.whatsapp = waError;

    // 2. Cek Jika Ada Error
    if (nimError || waError) {
        // Tampilkan pesan global dan HENTIKAN proses kirim
        formError.value = "Data belum valid. Mohon perbaiki kolom berwarna merah.";
        
        // Opsional: Scroll ke input yang salah agar user sadar
        if (nimError) document.getElementById('nimInput')?.focus();
        else if (waError) document.getElementById('waInput')?.focus();
        
        return;
    }

    // 3. Jika Lolos Validasi -> Kirim ke Server
    form.post('/book-reservation', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset();
            errors.nimNip = null;
            errors.whatsapp = null;
            formError.value = '';
            
            setTimeout(() => {
                messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        },
        onError: (err) => {
            console.error("Gagal submit:", err);
            formError.value = "Terjadi kesalahan pada server. Coba lagi nanti.";
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
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><User class="h-5 w-5" /></div>
                                        <input v-model="form.namaLengkap" type="text" class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan nama lengkap sesuai KTM" required />
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">NIM / NIP <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 transition-colors" 
                                             :class="errors.nimNip ? 'text-red-400' : (form.nimNip ? 'text-green-500' : 'text-slate-400')">
                                            <Hash class="h-5 w-5" />
                                        </div>
                                        
                                        <input 
                                            id="nimInput"
                                            :value="form.nimNip"
                                            @input="handleNimInput"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="errors.nimNip 
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' 
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Masukkan NIM atau NIP (9-10 digit)" required inputmode="numeric" 
                                        />

                                        <div v-if="form.nimNip.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="!errors.nimNip" class="h-5 w-5 text-green-500" />
                                            <AlertTriangle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>
                                    
                                    <div class="min-h-[1.5rem] mt-2">
                                        <transition enter-active-class="transition-opacity duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <p v-if="errors.nimNip" class="text-xs font-medium flex items-center gap-1 text-red-500">
                                                {{ errors.nimNip }}
                                            </p>
                                        </transition>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">WhatsApp (Aktif) <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 transition-colors"
                                             :class="errors.whatsapp ? 'text-red-400' : (form.whatsapp ? 'text-green-500' : 'text-slate-400')">
                                            <MessageCircle class="h-5 w-5" />
                                        </div>
                                        
                                        <input 
                                            id="waInput"
                                            :value="form.whatsapp"
                                            @input="handleWaInput"
                                            type="text" 
                                            class="w-full rounded-xl border py-3 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="errors.whatsapp 
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900' 
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Contoh: 081234567890" required inputmode="numeric" 
                                        />

                                        <div v-if="form.whatsapp.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="!errors.whatsapp" class="h-5 w-5 text-green-500" />
                                            <AlertTriangle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>

                                    <div class="min-h-[1.5rem] mt-2">
                                        <transition enter-active-class="transition-opacity duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <p v-if="errors.whatsapp" class="text-xs font-medium flex items-center gap-1 text-red-500">
                                                {{ errors.whatsapp }}
                                            </p>
                                        </transition>
                                    </div>
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
                                :disabled="form.processing"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-4 text-lg font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/50 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed"
                            >
                                <CalendarCheck v-if="!form.processing" class="h-5 w-5" />
                                <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ form.processing ? 'Mengirim...' : 'Kirim Permintaan Booking' }}
                            </button>
                            
                            <transition enter-active-class="transition-all duration-300" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition-all duration-200" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
                                <p v-if="formError" class="mt-4 text-center text-sm text-red-500 font-medium bg-red-50 p-2 rounded-lg border border-red-100">
                                    <AlertTriangle class="inline-block w-4 h-4 mr-1 -mt-0.5" />
                                    {{ formError }}
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