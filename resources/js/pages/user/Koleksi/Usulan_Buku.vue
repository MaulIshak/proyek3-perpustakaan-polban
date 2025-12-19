<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import {
    AlignLeft,
    Barcode,
    BookOpen,
    BookPlus,
    Building2,
    Calendar,
    CheckCircle2,
    DollarSign,
    GraduationCap,
    Hash,
    Loader2,
    PenTool,
    Send,
    User,
} from 'lucide-vue-next';
import { nextTick, ref, reactive, computed } from 'vue'; // Tambah reactive & computed

const breadcrumb = [
    { label: 'Home', link: '/' },
    { label: 'Koleksi' },
    { label: 'Form Usulan Buku' },
];

const showMessage = ref(false);
const messageRef = ref<HTMLElement | null>(null);

// State untuk error validasi live (Client-side)
const liveErrors = reactive<Record<string, string>>({
    nama_pengusul: '',
    nim: '',
    prodi: '',
    title: '',
    author: '',
    publisher: '',
    isbn: '',
    year: '',
    reason: '',
});

// --- STATE MODAL KONFORMASI ---
const showConfirmModal = ref(false);

const form = useForm({
    nama_pengusul: '',
    nim: '',
    prodi: '',
    title: '',
    author: '',
    isbn: '',
    publisher: '',
    year: '',
    price: '',
    reason: '',
    status: 'pending',
});

// --- LOGIKA VALIDASI LIVE ---
const validateField = (field: string) => {
    const value = form[field as keyof typeof form];

    // Reset error backend (Inertia) saat user mengetik
    if (form.errors[field as keyof typeof form.errors]) {
        form.clearErrors(field as keyof typeof form.errors);
    }

    // Reset error live spesifik field ini dulu
    liveErrors[field] = '';

    // Aturan Validasi
    switch (field) {
        case 'nama_pengusul':
            if (!value) liveErrors.nama_pengusul = 'Nama wajib diisi.';
            else if ((value as string).length < 3) liveErrors.nama_pengusul = 'Nama terlalu pendek (min. 3 karakter).';
            break;

        case 'nim':
            if (!value) liveErrors.nim = 'NIM wajib diisi.';
            else if (!/^\d+$/.test(value as string)) liveErrors.nim = 'NIM harus berupa angka.';
            else if ((value as string).length < 5) liveErrors.nim = 'NIM tidak valid.';
            break;

        case 'prodi':
            if (!value) liveErrors.prodi = 'Prodi wajib diisi.';
            break;

        case 'title':
            if (!value) liveErrors.title = 'Judul buku wajib diisi.';
            break;

        case 'author':
            if (!value) liveErrors.author = 'Nama pengarang wajib diisi.';
            break;

        case 'publisher':
            if (!value) liveErrors.publisher = 'Penerbit wajib diisi.';
            break;

        case 'isbn':
            if (!value) liveErrors.isbn = 'ISBN wajib diisi.';
            // Contoh validasi sederhana: minimal 10 karakter
            else if ((value as string).replace(/-/g, '').length < 10) liveErrors.isbn = 'Format ISBN tampaknya kurang lengkap.';
            break;

        case 'year':
            const currentYear = new Date().getFullYear();
            if (!value) liveErrors.year = 'Tahun wajib diisi.';
            else if (Number(value) < 1900 || Number(value) > currentYear + 1) liveErrors.year = `Tahun tidak valid (1900 - ${currentYear + 1}).`;
            break;

        case 'reason':
             // Opsional: jika ingin validasi alasan
             // if (!value) liveErrors.reason = 'Alasan usulan sebaiknya diisi.';
             break;
    }
};

// Helper untuk mengecek apakah ada error (gabungan Backend + Live)
const hasError = (field: string) => {
    return !!(form.errors[field as keyof typeof form.errors] || liveErrors[field]);
};

// Helper untuk mengambil pesan error (Prioritas: Live > Backend)
const getErrorMessage = (field: string) => {
    return liveErrors[field] || form.errors[field as keyof typeof form.errors];
};

const submitForm = () => {
    // Validasi semua field sebelum submit
    Object.keys(liveErrors).forEach(key => validateField(key));

    // Jika ada error di liveErrors, batalkan submit
    const hasLiveErrors = Object.values(liveErrors).some(err => err !== '');
    if (hasLiveErrors) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }

    // Tampilkan Modal Konfirmasi
    showConfirmModal.value = true;
};

// --- KONFIRMASI SUBMIT ---
const confirmSubmit = () => {
    showConfirmModal.value = false;
    form.post('usulan-buku/store', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset();
            // Reset live errors juga
            Object.keys(liveErrors).forEach(k => liveErrors[k] = '');

            nextTick(() => {
                messageRef.value?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            });

            setTimeout(() => {
                showMessage.value = false;
            }, 5000);
        },
        onError: (errors) => {
            console.error('Gagal validasi backend:', errors);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    });
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Form Usulan Buku">
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
                        <h3 class="mb-1 text-lg font-bold text-emerald-800">Terima Kasih! 🙌</h3>
                        <p class="leading-snug text-sm text-emerald-700">Usulan Anda telah kami terima dan akan diproses oleh pihak perpustakaan. Cek ketersediaan secara berkala.</p>
                    </div>
                </div>
            </transition>

                <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
                <div class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[var(--dark-green)]"></div>

                <div class="p-6 sm:p-8">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div>
                            <h3 class="mb-4 flex items-center gap-2 border-b border-slate-100 pb-2 text-base font-bold text-slate-800">
                                <User class="h-5 w-5 text-[#99cc33]" />
                                Data Pengusul
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <User class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.nama_pengusul"
                                            @input="validateField('nama_pengusul')"
                                            @blur="validateField('nama_pengusul')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('nama_pengusul')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Masukkan nama lengkap Anda"
                                        />
                                    </div>
                                    <p v-if="hasError('nama_pengusul')" class="mt-1 text-sm text-red-500 animate-pulse">
                                        {{ getErrorMessage('nama_pengusul') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">NIM / NIP <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <Hash class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.nim"
                                            @input="validateField('nim')"
                                            @blur="validateField('nim')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('nim')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Nomor Induk"
                                        />
                                    </div>
                                    <p v-if="hasError('nim')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('nim') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Program Studi / Unit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <GraduationCap class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.prodi"
                                            @input="validateField('prodi')"
                                            @blur="validateField('prodi')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('prodi')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Contoh: D3 Teknik Informatika"
                                        />
                                    </div>
                                    <p v-if="hasError('prodi')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('prodi') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="mb-4 flex items-center gap-2 border-b border-slate-100 pb-2 text-base font-bold text-slate-800">
                                <BookPlus class="h-5 w-5 text-[#99cc33]" />
                                Detail Buku
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <BookOpen class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.title"
                                            @input="validateField('title')"
                                            @blur="validateField('title')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('title')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Judul lengkap buku"
                                        />
                                    </div>
                                    <p v-if="hasError('title')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('title') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <PenTool class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.author"
                                            @input="validateField('author')"
                                            @blur="validateField('author')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('author')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Nama penulis"
                                        />
                                    </div>
                                    <p v-if="hasError('author')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('author') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Penerbit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <Building2 class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.publisher"
                                            @input="validateField('publisher')"
                                            @blur="validateField('publisher')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('publisher')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Nama penerbit"
                                        />
                                    </div>
                                    <p v-if="hasError('publisher')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('publisher') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">ISBN <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <Barcode class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.isbn"
                                            @input="validateField('isbn')"
                                            @blur="validateField('isbn')"
                                            type="text"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('isbn')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="Contoh: 978-602-..."
                                        />
                                    </div>
                                    <p v-if="hasError('isbn')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('isbn') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Tahun Terbit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <Calendar class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.year"
                                            @input="validateField('year')"
                                            @blur="validateField('year')"
                                            type="number"
                                            min="1900"
                                            :max="new Date().getFullYear() + 1"
                                            class="w-full rounded-xl border py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:ring-2"
                                            :class="hasError('year')
                                                ? 'border-red-500 focus:border-red-500 focus:ring-red-200'
                                                : 'border-slate-200 focus:border-[#99cc33] focus:ring-[#99cc33]/20'"
                                            placeholder="YYYY"
                                        />
                                    </div>
                                    <p v-if="hasError('year')" class="mt-1 text-sm text-red-500">
                                        {{ getErrorMessage('year') }}
                                    </p>
                                </div>

                                    <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Perkiraan Harga (Opsional)</label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <DollarSign class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.price"
                                            type="number"
                                            min="0"
                                            class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Rp"
                                        />
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Alasan Usulan</label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute top-3 left-3 flex items-start text-slate-400">
                                            <AlignLeft class="h-5 w-5" />
                                        </div>
                                        <textarea
                                                v-model="form.reason"
                                                rows="4"
                                                class="w-full resize-none rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none placeholder:text-slate-400 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Jelaskan mengapa buku ini penting untuk koleksi perpustakaan..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="border-t border-slate-100 pt-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-3 text-base font-bold text-white shadow-md shadow-[#99cc33]/20 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/40 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-70 disabled:hover:translate-y-0"
                                >
                                    <Loader2 v-if="form.processing" class="h-5 w-5 animate-spin" />
                                    <Send v-else class="h-5 w-5" />
                                    {{ form.processing ? 'Mengirim...' : 'Kirim Usulan Buku' }}
                                </button>
                                <p class="mt-3 text-center text-sm text-slate-400">
                                    Pastikan semua data bertanda bintang (*) telah diisi dengan benar.
                                </p>
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
                <div class="mx-4 w-full max-w-lg rounded-2xl bg-white p-4 shadow-2xl max-h-[80vh] overflow-y-auto">
                    <h3 class="mb-4 text-xl font-bold text-slate-800">Konfirmasi Usulan Buku</h3>
                    <p class="mb-4 text-slate-600">Pastikan data di bawah ini sudah benar sebelum mengirim:</p>

                    <div class="space-y-3 rounded-lg bg-slate-50 p-4">
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Nama Pengusul:</span>
                                <span class="text-slate-800 text-right">{{ form.nama_pengusul }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">NIM/NIP:</span>
                                <span class="text-slate-800">{{ form.nim }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Program Studi:</span>
                                <span class="text-slate-800">{{ form.prodi }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Judul Buku:</span>
                                <span class="text-slate-800 text-right">{{ form.title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Pengarang:</span>
                                <span class="text-slate-800">{{ form.author }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Penerbit:</span>
                                <span class="text-slate-800">{{ form.publisher }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">ISBN:</span>
                                <span class="text-slate-800">{{ form.isbn }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-slate-700">Tahun Terbit:</span>
                                <span class="text-slate-800">{{ form.year }}</span>
                            </div>
                            <div v-if="form.price" class="flex justify-between">
                                <span class="font-medium text-slate-700">Perkiraan Harga:</span>
                                <span class="text-slate-800">Rp {{ form.price }}</span>
                            </div>
                            <div v-if="form.reason" class="col-span-2">
                                <span class="font-medium text-slate-700">Alasan Usulan:</span>
                                <p class="mt-1 text-slate-800 bg-white p-2 rounded border">{{ form.reason }}</p>
                            </div>
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
                            {{ form.processing ? 'Mengirim...' : 'Ya, Kirim Usulan' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </Layout>
</template>
