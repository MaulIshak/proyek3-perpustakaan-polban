<script setup>
import { ref, nextTick } from 'vue';
import Layout from '@/layouts/UserAppLayout.vue';

const breadcrumb = [
    { label: 'Pelayanan' },
    { label: 'Form Usulan Buku' },
];

const showMessage = ref(false);
const messageRef = ref(null);

const submitForm = async (e) => {
    e.preventDefault();

    showMessage.value = true;

    await nextTick(); // tunggu DOM update

    // scroll halus menuju pesan
    messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" title="Form Usulan Buku">
        <div class="py-12">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-center">
                    
                    <div class="bg-white rounded-xl shadow-xl p-10 w-full max-w-7xl border border-[var(--primary-green)]">
                        <!-- SUCCESS MESSAGE -->
                        <div
                            v-if="showMessage"
                            ref="messageRef"
                            class="mt-10 p-6 rounded-xl border border-green-400 bg-green-50 shadow-md animate-[fadeInUp_.5s_ease]"
                        >
                            <h2 class="text-2xl font-bold text-green-700 mb-2">
                                Terimakasih sudah mengusul buku 🙌
                            </h2>
                            <p class="text-green-800 text-lg">
                                Usulan Anda telah kami terima dan akan diproses oleh pihak perpustakaan.
                            </p>
                        </div>
                        
                        <!-- TITLE -->
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            Form Usulan Buku Perpustakaan POLBAN
                        </h1>

                        <p class="text-gray-700 leading-relaxed mb-6 text-1xl">
                            Silahkan usulkan buku-buku yang Anda perlukan dengan mengisi formulir yang telah kami sediakan. 
                        </p>

                        <!-- FORM -->
                        <form class="space-y-5" @submit="submitForm">

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Nama Pengusul <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Nim <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Prodi <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Judul <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Pengarang <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    ISBN <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Penerbit <span class="text-red-600">*</span>
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Tahun <span class="text-red-600">*</span>
                                </label>
                                <input type="number" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" required />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Harga (Opsional)
                                </label>
                                <input type="number" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" />
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Alasan Usulan Buku
                                </label>
                                <input type="text" class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" />
                            </div>

                            <!-- BUTTON -->
                            <button
                                type="submit"
                                class="w-full py-3 bg-[var(--primary-green)] text-white font-semibold rounded-lg hover:opacity-90 transition"
                            >
                                Kirim Usulan
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </Layout>
</template>

<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
