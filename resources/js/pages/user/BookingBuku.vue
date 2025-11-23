<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { useForm } from '@inertiajs/vue3'; // WAJIB IMPORT INI
import {
    BookOpen,
    CalendarCheck,
    CheckCircle2,
    Hash,
    Mail,
    MessageCircle,
    PenTool,
    User,
} from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    title: string;
}>();

const breadcrumb = [{ label: 'Home', link: '/' }, { label: 'Booking Buku' }];

// GUNAKAN useForm DARI INERTIA
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

const submitForm = () => {
    // Kirim data ke route booking.store
    form.post('/book-reservation', {
        preserveScroll: true,
        onSuccess: () => {
            // Tampilkan pesan sukses
            showMessage.value = true;
            
            // Reset form
            form.reset();

            // Scroll ke pesan sukses
            setTimeout(() => {
                messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        },
        onError: (errors) => {
            console.error("Gagal submit:", errors);
            // Opsional: Scroll ke atas jika error
        }
    });
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <!-- Background Decoration (Consistent) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header Section
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    {{ title }}
                </h1>
                <p class="text-slate-600 text-lg">
                    Pesan buku yang sedang dipinjam agar Anda menjadi prioritas peminjam berikutnya saat buku tersedia.
                </p>
                <div class="flex justify-center mt-6">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <!-- Success Message -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div
                    v-if="showMessage"
                    ref="messageRef"
                    class="mx-auto mb-8 flex max-w-4xl items-start gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-lg"
                >
                    <div
                        class="shrink-0 rounded-full bg-emerald-100 p-2 text-emerald-600"
                    >
                        <CheckCircle2 class="h-8 w-8" />
                    </div>
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-emerald-800">
                            Booking Berhasil! 📚
                        </h3>
                        <p class="leading-relaxed text-emerald-700">
                            Permintaan booking Anda telah dicatat. Kami akan
                            menghubungi Anda melalui WhatsApp/Email segera
                            setelah buku tersedia.
                        </p>
                    </div>
                </div>
            </transition>

            <!-- Form Card -->
            <div
                class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"
            >
                <!-- Decorative Top Bar -->
                <div
                    class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[var(--dark-green)]"
                ></div>

                <div class="p-8 sm:p-10">
                    <form @submit.prevent="submitForm" class="space-y-10">
                        <!-- Group 1: Data Peminjam -->
                        <div>
                            <h3
                                class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800"
                            >
                                <User class="h-5 w-5 text-[#99cc33]" />
                                Data Peminjam
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Nama -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Nama Lengkap
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <User class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.namaLengkap"
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Masukkan nama lengkap sesuai KTM"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- NIM/NIP -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >NIM / NIP
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <Hash class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.nimNip"
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Nomor Induk Mahasiswa/Pegawai"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >WhatsApp (Aktif)
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <MessageCircle class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.whatsapp"
                                            type="tel"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="08xxxxxxxxxx"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Email
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <Mail class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="email@polban.ac.id"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: Data Buku -->
                        <div>
                            <h3
                                class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800"
                            >
                                <BookOpen class="h-5 w-5 text-[#99cc33]" />
                                Buku yang Dipesan
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Judul Buku -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Judul Buku
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <BookOpen class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.judulBuku"
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Masukkan judul buku lengkap"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Pengarang -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Pengarang
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <PenTool class="h-5 w-5" />
                                        </div>
                                        <input
                                            v-model="form.pengarang"
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Nama pengarang"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-4 text-lg font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/50 active:translate-y-0"
                            >
                                <CalendarCheck class="h-5 w-5" />
                                Kirim Permintaan Booking
                            </button>
                            <p class="mt-4 text-center text-sm text-slate-400">
                                Pastikan data yang Anda masukkan valid agar kami
                                dapat menghubungi Anda.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
