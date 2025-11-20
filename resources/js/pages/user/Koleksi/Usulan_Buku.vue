<script setup lang="ts">
import { ref, nextTick } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';
import {
    BookPlus,
    User,
    Hash,
    GraduationCap,
    BookOpen,
    PenTool,
    Calendar,
    DollarSign,
    AlignLeft,
    Send,
    CheckCircle2,
    Building2,
    Barcode
} from 'lucide-vue-next';

const breadcrumb = [
    { label: 'Pelayanan' },
    { label: 'Form Usulan Buku' },
];

const showMessage = ref(false);
const messageRef = ref<HTMLElement | null>(null);

// Simulasi submit
const submitForm = async (e: Event) => {
    e.preventDefault();

    showMessage.value = true;
    await nextTick();

    // Scroll halus ke pesan sukses
    messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Optional: Reset form logic here
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Form Usulan Buku">

        <!-- Background Decoration -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#99cc33]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gray-100 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 relative">

            <!-- Header Section
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Usulkan Koleksi Baru
                </h1>
                <p class="text-slate-600 text-lg">
                    Bantu kami melengkapi koleksi perpustakaan dengan mengusulkan buku-buku berkualitas yang Anda butuhkan.
                </p>
                <div class="flex justify-center mt-6">
                    <div class="h-1.5 w-20 bg-[#99cc33] rounded-full shadow-sm shadow-[#99cc33]/50"></div>
                </div>
            </div> -->

            <!-- Success Message (Transition) -->
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
                        <h3 class="text-xl font-bold text-emerald-800 mb-1">Terima Kasih! 🙌</h3>
                        <p class="text-emerald-700 leading-relaxed">
                            Usulan buku Anda telah berhasil kami terima. Tim pengadaan kami akan meninjau usulan tersebut. Cek status pengadaan secara berkala.
                        </p>
                    </div>
                </div>
            </transition>

            <!-- Form Card -->
            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                <!-- Decorative Top Bar -->
                <div class="h-2 w-full bg-gradient-to-r from-[#99cc33] to-[#7aace5]"></div>

                <div class="p-8 sm:p-10">
                    <form @submit="submitForm" class="space-y-10">

                        <!-- Section: Data Diri -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                                <User class="w-5 h-5 text-[#99cc33]" />
                                Data Pengusul
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <User class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Masukkan nama lengkap Anda" required />
                                    </div>
                                </div>

                                <!-- NIM/NIP -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIM / NIP <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Hash class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Nomor Induk" required />
                                    </div>
                                </div>

                                <!-- Prodi/Unit -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Program Studi / Unit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <GraduationCap class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Contoh: D3 Teknik Informatika" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Buku -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                                <BookPlus class="w-5 h-5 text-[#99cc33]" />
                                Detail Buku
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Judul Buku -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <BookOpen class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Judul lengkap buku" required />
                                    </div>
                                </div>

                                <!-- Pengarang -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pengarang <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <PenTool class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Nama penulis/pengarang" required />
                                    </div>
                                </div>

                                <!-- Penerbit -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Building2 class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Nama penerbit" required />
                                    </div>
                                </div>

                                <!-- ISBN -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">ISBN <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Barcode class="w-5 h-5" />
                                        </div>
                                        <input type="text" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Contoh: 978-602-..." required />
                                    </div>
                                </div>

                                <!-- Tahun -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <Calendar class="w-5 h-5" />
                                        </div>
                                        <input type="number" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="YYYY" required />
                                    </div>
                                </div>

                                <!-- Harga (Optional) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perkiraan Harga (Opsional)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <DollarSign class="w-5 h-5" />
                                        </div>
                                        <input type="number" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700" placeholder="Rp" />
                                    </div>
                                </div>

                                <!-- Alasan -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Usulan</label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-3 flex items-start pointer-events-none text-slate-400">
                                            <AlignLeft class="w-5 h-5" />
                                        </div>
                                        <textarea rows="4" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20 transition-all outline-none text-slate-700 resize-none" placeholder="Jelaskan mengapa buku ini penting untuk koleksi perpustakaan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button
                                type="submit"
                                class="w-full flex items-center justify-center gap-2 py-4 bg-[#99cc33] hover:bg-[#88b82d] text-white font-bold text-lg rounded-xl shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:shadow-[#99cc33]/50 hover:-translate-y-1 active:translate-y-0"
                            >
                                <Send class="w-5 h-5" />
                                Kirim Usulan Buku
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </Layout>
</template>
