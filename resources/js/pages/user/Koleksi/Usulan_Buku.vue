<script setup>
import { ref, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from '@/layouts/UserAppLayout.vue';

const breadcrumb = [
    { label: 'Pelayanan' },
    { label: 'Form Usulan Buku' },
];

const showMessage = ref(false);
const messageRef = ref(null);

// Inertia form with all fields
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
    status: 'pending', // Default status for user submissions
});

const submitForm = () => { // Hapus async dan e.preventDefault karena useForm sudah handle itu
    form.post('usulan-buku/store', {
        preserveScroll: true,
        onSuccess: () => {
            showMessage.value = true;
            form.reset(); 
            
            // Scroll ke pesan sukses
            nextTick(() => {
                messageRef.value?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });

            // Sembunyikan pesan otomatis setelah 5 detik (opsional)
            setTimeout(() => {
                showMessage.value = false;
            }, 5000);
        },
        onError: (errors) => {
            // Jika validasi Laravel gagal, Inertia otomatis mengisi form.errors
            console.error('Gagal validasi:', errors);
            
            // Opsional: Scroll ke atas jika ada error agar user sadar
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
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
                            class="mb-6 p-6 rounded-xl border border-green-400 bg-green-50 shadow-md animate-[fadeInUp_.5s_ease]"
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
                                <input 
                                    v-model="form.nama_pengusul"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.nama_pengusul }"
                                    required 
                                />
                                <p v-if="form.errors.nama_pengusul" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.nama_pengusul }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    NIM <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.nim"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.nim }"
                                    required 
                                />
                                <p v-if="form.errors.nim" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.nim }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Prodi <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.prodi"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.prodi }"
                                    required 
                                />
                                <p v-if="form.errors.prodi" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.prodi }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Judul Buku <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.title"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.title }"
                                    required 
                                />
                                <p v-if="form.errors.title" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Pengarang <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.author"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.author }"
                                    required 
                                />
                                <p v-if="form.errors.author" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.author }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    ISBN <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.isbn"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.isbn }"
                                    required 
                                />
                                <p v-if="form.errors.isbn" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.isbn }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Penerbit <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.publisher"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.publisher }"
                                    required 
                                />
                                <p v-if="form.errors.publisher" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.publisher }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Tahun Terbit <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    v-model="form.year"
                                    type="number" 
                                    min="1700"
                                    :max="new Date().getFullYear()"
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.year }"
                                    required 
                                />
                                <p v-if="form.errors.year" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.year }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Harga (Opsional)
                                </label>
                                <input 
                                    v-model="form.price"
                                    type="number" 
                                    min="0"
                                    placeholder="Contoh: 150000"
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.price }"
                                />
                                <p v-if="form.errors.price" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.price }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-semibold mb-1">
                                    Alasan Usulan Buku
                                </label>
                                <textarea
                                    v-model="form.reason"
                                    rows="4"
                                    placeholder="Jelaskan mengapa buku ini diperlukan..."
                                    class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-[var(--primary-green)]" 
                                    :class="{ 'border-red-500': form.errors.reason }"
                                />
                                <p v-if="form.errors.reason" class="text-sm text-red-500 mt-1">
                                    {{ form.errors.reason }}
                                </p>
                            </div>

                            <!-- BUTTON -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full py-3 bg-[var(--primary-green)] text-white font-semibold rounded-lg hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ form.processing ? 'Mengirim...' : 'Kirim Usulan' }}
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