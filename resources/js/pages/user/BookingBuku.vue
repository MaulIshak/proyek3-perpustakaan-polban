<script setup lang="ts">
import { ref, nextTick } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import {
    User,
    Hash,
    Mail,
    MessageCircle,
    BookOpen,
    PenTool,
    CheckCircle2,
    CalendarCheck
} from 'lucide-vue-next';

defineProps<{
    title: string;
}>();

const breadcrumb = [{ label: 'Booking Buku' }];

const form = ref({
    namaLengkap: '',
    nimNip: '',
    email: '',
    whatsapp: '',
    judulBuku: '',
    pengarang: '',
});

const showMessage = ref(false);
const messageRef = ref<HTMLElement | null>(null);

const submitForm = async () => {
    // Simulasi submit (di sini nanti Anda bisa ganti dengan Inertia form.post)
    console.log('Permintaan Booking Dikirim:', form.value);

    showMessage.value = true;
    await nextTick();

    // Scroll ke pesan sukses agar user sadar
    messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">

        <!-- Background Decoration (Consistent) -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative">

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
                    class="max-w-4xl mx-auto mb-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-lg flex items-start gap-4"
                >
                    <div class="p-2 bg-emerald-100 rounded-full text-emerald-600 shrink-0">
                        <CheckCircle2 class="w-8 h-8" />
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-emerald-800 mb-1">Booking Berhasil! 📚</h3>
                        <p class="text-emerald-700 leading-relaxed">
                            Permintaan booking Anda telah dicatat. Kami akan menghubungi Anda melalui WhatsApp/Email segera setelah buku tersedia.
                        </p>
                    </div>
                </div>
            </transition>

            <!-- Form Card -->
            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                <!-- Decorative Top Bar -->
                <div class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[#7aace5]"></div>

                <div class="p-8 sm:p-10">
                    <form @submit.prevent="submitForm" class="space-y-10">

                        <!-- Group 1: Data Peminjam -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                                <User class="w-5 h-5 text-[#99cc33]" />
                                Data Peminjam
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <User class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.namaLengkap"
                                            type="text"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
                                            placeholder="Masukkan nama lengkap sesuai KTM"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- NIM/NIP -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIM / NIP <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Hash class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.nimNip"
                                            type="text"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
                                            placeholder="Nomor Induk Mahasiswa/Pegawai"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">WhatsApp (Aktif) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <MessageCircle class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.whatsapp"
                                            type="tel"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
                                            placeholder="08xxxxxxxxxx"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Mail class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
                                            placeholder="email@polban.ac.id"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: Data Buku -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                                <BookOpen class="w-5 h-5 text-[#99cc33]" />
                                Buku yang Dipesan
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Judul Buku -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <BookOpen class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.judulBuku"
                                            type="text"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
                                            placeholder="Masukkan judul buku lengkap"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Pengarang -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <PenTool class="w-5 h-5" />
                                        </div>
                                        <input
                                            v-model="form.pengarang"
                                            type="text"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700"
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
                                class="w-full flex items-center justify-center gap-2 py-4 bg-[#99cc33] hover:bg-[#88b82d] text-white font-bold text-lg rounded-xl shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:shadow-[#99cc33]/50 hover:-translate-y-1 active:translate-y-0"
                            >
                                <CalendarCheck class="w-5 h-5" />
                                Kirim Permintaan Booking
                            </button>
                            <p class="text-center text-slate-400 text-sm mt-4">
                                Pastikan data yang Anda masukkan valid agar kami dapat menghubungi Anda.
                            </p>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </Layout>
</template>
