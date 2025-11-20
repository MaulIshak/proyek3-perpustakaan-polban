<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
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
    PenTool,
    Send,
    User,
} from 'lucide-vue-next';
import { nextTick, ref } from 'vue';

const breadcrumb = [
    { label: 'Home', link: '/' },
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
                    class="mx-auto mb-8 flex max-w-4xl items-start gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-lg"
                >
                    <div
                        class="shrink-0 rounded-full bg-emerald-100 p-2 text-emerald-600"
                    >
                        <CheckCircle2 class="h-8 w-8" />
                    </div>
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-emerald-800">
                            Terima Kasih! 🙌
                        </h3>
                        <p class="leading-relaxed text-emerald-700">
                            Usulan buku Anda telah berhasil kami terima. Tim
                            pengadaan kami akan meninjau usulan tersebut. Cek
                            status pengadaan secara berkala.
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
                    <form @submit="submitForm" class="space-y-10">
                        <!-- Section: Data Diri -->
                        <div>
                            <h3
                                class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800"
                            >
                                <User class="h-5 w-5 text-[#99cc33]" />
                                Data Pengusul
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
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Masukkan nama lengkap Anda"
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
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Nomor Induk"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Prodi/Unit -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Program Studi / Unit
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <GraduationCap class="h-5 w-5" />
                                        </div>
                                        <input
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Contoh: D3 Teknik Informatika"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Buku -->
                        <div>
                            <h3
                                class="mb-6 flex items-center gap-2 border-b border-slate-100 pb-2 text-lg font-bold text-slate-800"
                            >
                                <BookPlus class="h-5 w-5 text-[#99cc33]" />
                                Detail Buku
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
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Judul lengkap buku"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Pengarang -->
                                <div>
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
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Nama penulis/pengarang"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Penerbit -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Penerbit
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <Building2 class="h-5 w-5" />
                                        </div>
                                        <input
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Nama penerbit"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- ISBN -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >ISBN
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <Barcode class="h-5 w-5" />
                                        </div>
                                        <input
                                            type="text"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Contoh: 978-602-..."
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Tahun -->
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Tahun Terbit
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <Calendar class="h-5 w-5" />
                                        </div>
                                        <input
                                            type="number"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="YYYY"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Harga (Optional) -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Perkiraan Harga (Opsional)</label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                        >
                                            <DollarSign class="h-5 w-5" />
                                        </div>
                                        <input
                                            type="number"
                                            class="w-full rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Rp"
                                        />
                                    </div>
                                </div>

                                <!-- Alasan -->
                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Alasan Usulan</label
                                    >
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute top-3 left-3 flex items-start text-slate-400"
                                        >
                                            <AlignLeft class="h-5 w-5" />
                                        </div>
                                        <textarea
                                            rows="4"
                                            class="w-full resize-none rounded-xl border border-slate-200 py-3 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]/20"
                                            placeholder="Jelaskan mengapa buku ini penting untuk koleksi perpustakaan..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button
                                type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#99cc33] py-4 text-lg font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all duration-300 hover:-translate-y-1 hover:bg-[#88b82d] hover:shadow-[#99cc33]/50 active:translate-y-0"
                            >
                                <Send class="h-5 w-5" />
                                Kirim Usulan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
