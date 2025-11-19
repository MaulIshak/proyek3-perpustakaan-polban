<script setup lang="ts">
import Layout from '@/layouts/UserAppLayout.vue';
import { ref } from 'vue';

// Definisikan props dari parent component
defineProps({
    title: {
        type: String,
        required: true,
    },
    // ... props lainnya yang tidak digunakan di sini tapi ada di script asli
    subjudul_1: String,
    subjudul_2: String,
    subjudul_3: String,
    description: String,
    visi: String,
    misi: Array as () => string[],
});

// State untuk form input
const form = ref({
    namaLengkap: '',
    nimNip: '',
    email: '',
    whatsapp: '',
    judulBuku: '',
    pengarang: '',
});

// Breadcrumb
const breadcrumb = [{ label: 'Booking Buku' }];

// Fungsi yang akan dipanggil saat form disubmit
const submitForm = () => {
    console.log('Permintaan Booking Dikirim:', form.value);
    // Tambahkan logika pengiriman data ke backend di sini
    alert('Permintaan Booking berhasil dikirim!');
};
</script>

<template>
    <Layout :page="true" :breadcrumb="breadcrumb" :title="title">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-10">
                <div class="text-center mb-10">
                    <p class="text-gray-500 mt-1">
                        Pesan buku yang sedang dipinjam dan kami akan memberitahu Anda saat tersedia
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 md:p-8 border border-gray-100">
                    <form @submit.prevent="submitForm">
                        
                        <div class="mb-5">
                            <label for="namaLengkap" class="block text-sm font-medium text-red-500">
                                Nama Lengkap *
                            </label>
                            <input 
                                type="text" 
                                id="namaLengkap" 
                                v-model="form.namaLengkap" 
                                placeholder="Masukkan nama lengkap" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>

                        <div class="mb-5">
                            <label for="nimNip" class="block text-sm font-medium text-red-500">
                                NIM/NIP *
                            </label>
                            <input 
                                type="text" 
                                id="nimNip" 
                                v-model="form.nimNip" 
                                placeholder="Masukkan NIM atau NIP" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>
                        
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-red-500">
                                Email *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                v-model="form.email" 
                                placeholder="email@example.com" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>

                        <div class="mb-5">
                            <label for="whatsapp" class="block text-sm font-medium text-red-500">
                                Nomor WhatsApp (Aktif) *
                            </label>
                            <input 
                                type="tel" 
                                id="whatsapp" 
                                v-model="form.whatsapp" 
                                placeholder="08xxxxxxxxxxxx" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>

                        <div class="mb-5">
                            <label for="judulBuku" class="block text-sm font-medium text-gray-700">
                                Judul Buku *
                            </label>
                            <input 
                                type="text" 
                                id="judulBuku" 
                                v-model="form.judulBuku" 
                                placeholder="Masukkan judul buku yang ingin dibooking" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>

                        <div class="mb-8">
                            <label for="pengarang" class="block text-sm font-medium text-gray-700">
                                Pengarang *
                            </label>
                            <input 
                                type="text" 
                                id="pengarang" 
                                v-model="form.pengarang" 
                                placeholder="Masukkan nama pengarang" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-2"
                                required
                            />
                        </div>

                        <button 
                            type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Kirim Permintaan Booking
                        </button>
                        
                    </form>
                </div>
                
                <div class="text-center mt-6">
                    <a href="/" class="text-sm text-gray-500 hover:text-green-600">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </Layout>
</template>