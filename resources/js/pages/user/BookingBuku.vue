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
const formError = ref('');

// --- STATE MODAL KONFORMASI ---
const showConfirmModal = ref(false);

// --- STATE VALIDASI ---
const errors = reactive({
    nimNip: null as string | null,
    whatsapp: null as string | null,
    email: null as string | null
});

// --- VALIDASI NIM / NIP ---
const validateNim = (value: string) => {
    if (!value) return "Wajib diisi.";
    if (/[^0-9]/.test(value)) return "Hanya boleh angka (0-9).";
    if (value.length < 9) return `Kurang (${value.length}/9 digit).`;
    return null;
};

// --- VALIDASI WHATSAPP ---
const validateWa = (value: string) => {
    if (!value) return "Wajib diisi.";
    if (/[^0-9]/.test(value)) return "Nomor HP hanya boleh angka.";
    if (value.length < 10) return `Kurang (${value.length}/10 digit).`;
    if (value.length > 15) return `Lebih (${value.length}/15 digit).`;
    return null;
};

// --- VALIDASI EMAIL POLBAN ---
const validateEmail = (value: string) => {
    if (!value) return "Wajib diisi.";
    if (!value.endsWith('@polban.ac.id')) {
        return "Wajib menggunakan email @polban.ac.id";
    }
    return null;
};

// --- HANDLER INPUT ---
const handleNimInput = (event: Event) => {
    const val = (event.target as HTMLInputElement).value;
    form.nimNip = val;
    errors.nimNip = validateNim(val);
    formError.value = '';
};

const handleWaInput = (event: Event) => {
    const val = (event.target as HTMLInputElement).value;
    form.whatsapp = val;
    errors.whatsapp = validateWa(val);
    formError.value = '';
};

const handleEmailInput = (event: Event) => {
    const val = (event.target as HTMLInputElement).value;
    form.email = val;
    errors.email = validateEmail(val);
    formError.value = '';
};

// --- SUBMIT FORM ---
const submitForm = () => {
    // 1. Validasi Menyeluruh
    const nimError = validateNim(form.nimNip);
    const waError = validateWa(form.whatsapp);
    const emailError = validateEmail(form.email);

    // Update state error visual
    errors.nimNip = nimError;
    errors.whatsapp = waError;
    errors.email = emailError;

    // 2. Cek Jika Ada Error
    if (nimError || waError || emailError) {
        formError.value = "Data belum valid. Mohon perbaiki kolom berwarna merah.";

        // Auto focus
        if (nimError) document.getElementById('nimInput')?.focus();
        else if (waError) document.getElementById('waInput')?.focus();
        else if (emailError) document.getElementById('emailInput')?.focus();

        return;
    }

    // 3. Tampilkan Modal Konfirmasi
    showConfirmModal.value = true;
};

// --- KONFIRMASI SUBMIT ---
const confirmSubmit = () => {
    showConfirmModal.value = false;
    form.post('/book-reservation', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset();
            errors.nimNip = null;
            errors.whatsapp = null;
            errors.email = null;
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

        <div class="relative container mx-auto px-4 py-6 sm:px-6 lg:px-8">

            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div v-if="showMessage" ref="messageRef" class="mx-auto mb-6 flex max-w-4xl items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-lg">
                    <div class="shrink-0 rounded-full bg-emerald-100 p-2 text-emerald-600">
                        <CheckCircle2 class="h-6 w-6" />
                    </div>
                    <div>
                        <h3 class="mb-1 text-lg font-bold text-emerald-800">Booking Berhasil! 📚</h3>
                        <p class="leading-snug text-sm text-emerald-700">
                            Permintaan booking Anda telah dicatat. Kami akan menghubungi Anda melalui WhatsApp/Email segera setelah buku tersedia.
                        </p>
                    </div>
                </div>
            </transition>

                <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
                <div class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[var(--dark-green)]"></div>

                <div class="p-6 sm:p-8">
                    <form @submit.prevent="submitForm" class="space-y-6">

                        <div>
                            <h3 class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800">
                                <User class="h-5 w-5 text-[#99cc33]" /> Data Peminjam
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><User class="h-5 w-5" /></div>
                                        <input v-model="form.namaLengkap" type="text" class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan nama lengkap sesuai KTM" required />
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
                                            class="w-full rounded-xl border py-2.5 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="errors.nimNip
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Masukkan NIM atau NIP" required inputmode="numeric"
                                        />

                                        <div v-if="form.nimNip.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="!errors.nimNip" class="h-5 w-5 text-green-500" />
                                            <AlertTriangle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>

                                    <transition enter-active-class="transition-opacity duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <p v-if="errors.nimNip" class="mt-2 text-xs font-medium flex items-center gap-1 text-red-500">
                                            {{ errors.nimNip }}
                                        </p>
                                    </transition>
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
                                            class="w-full rounded-xl border py-2.5 pr-10 pl-10 transition-all outline-none focus:ring-2"
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

                                    <transition enter-active-class="transition-opacity duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <p v-if="errors.whatsapp" class="mt-2 text-xs font-medium flex items-center gap-1 text-red-500">
                                            {{ errors.whatsapp }}
                                        </p>
                                    </transition>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email Polban <span class="text-red-500">*</span></label>
                                    <div class="relative group">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 transition-colors"
                                             :class="errors.email ? 'text-red-400' : (form.email ? 'text-green-500' : 'text-slate-400')">
                                            <Mail class="h-5 w-5" />
                                        </div>

                                        <input
                                            id="emailInput"
                                            :value="form.email"
                                            @input="handleEmailInput"
                                            type="email"
                                            class="w-full rounded-xl border py-2.5 pr-10 pl-10 transition-all outline-none focus:ring-2"
                                            :class="errors.email
                                                ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-200 text-red-900'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="nama.mahasiswa@polban.ac.id" required
                                        />

                                        <div v-if="form.email.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <Check v-if="!errors.email" class="h-5 w-5 text-green-500" />
                                            <AlertTriangle v-else class="h-5 w-5 text-red-500 animate-pulse" />
                                        </div>
                                    </div>

                                    <transition enter-active-class="transition-opacity duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <p v-if="errors.email" class="mt-2 text-xs font-medium flex items-center gap-1 text-red-500">
                                            {{ errors.email }}
                                        </p>
                                    </transition>
                                </div>

                            </div>
                        </div>

                        <div>
                            <h3 class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800">
                                <BookOpen class="h-5 w-5 text-[#99cc33]" /> Buku yang Dipesan
                            </h3>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><BookOpen class="h-5 w-5" /></div>
                                        <input v-model="form.judulBuku" type="text" class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Masukkan judul buku lengkap" required />
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><PenTool class="h-5 w-5" /></div>
                                        <input v-model="form.pengarang" type="text" class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20" placeholder="Nama pengarang" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-3 text-base font-bold text-white shadow-md shadow-[#99cc33]/20 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/40 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed"
                            >
                                <CalendarCheck v-if="!form.processing" class="h-5 w-5" />
                                <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ form.processing ? 'Mengirim...' : 'Kirim Permintaan Booking' }}
                            </button>

                            <transition enter-active-class="transition-all duration-300" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition-all duration-200" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
                                <p v-if="formError" class="mt-3 text-center text-sm text-red-500 font-medium bg-red-50 p-2 rounded-lg border border-red-100">
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

        <!-- Modal Konfirmasi -->
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
                <div v-if="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div class="mx-4 w-full max-w-lg rounded-2xl bg-white p-4 shadow-2xl">
                    <h3 class="mb-4 text-xl font-bold text-slate-800">Konfirmasi Booking Buku</h3>
                    <p class="mb-4 text-slate-600">Pastikan data di bawah ini sudah benar sebelum mengirim:</p>

                    <div class="space-y-3 rounded-lg bg-slate-50 p-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">Nama Lengkap:</span>
                            <span class="text-slate-800">{{ form.namaLengkap }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">NIM/NIP:</span>
                            <span class="text-slate-800">{{ form.nimNip }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">Email:</span>
                            <span class="text-slate-800">{{ form.email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">WhatsApp:</span>
                            <span class="text-slate-800">{{ form.whatsapp }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">Judul Buku:</span>
                            <span class="text-slate-800">{{ form.judulBuku }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-700">Pengarang:</span>
                            <span class="text-slate-800">{{ form.pengarang }}</span>
                        </div>
                    </div>

                    <p class="mt-4 text-center text-sm text-slate-500">Apakah data sudah benar?</p>

                    <div class="mt-4 flex gap-3">
                        <button
                            @click="showConfirmModal = false"
                            class="flex-1 rounded-xl border border-slate-300 py-2.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50"
                        >
                            Batal
                        </button>
                        <button
                            @click="confirmSubmit"
                            :disabled="form.processing"
                            class="flex-1 rounded-xl bg-[#99cc33] py-2.5 font-semibold text-white shadow-md transition-all hover:bg-[#88b82d] hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            {{ form.processing ? 'Mengirim...' : 'Ya, Kirim Booking' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </Layout>
</template>
