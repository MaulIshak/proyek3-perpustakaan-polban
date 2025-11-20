<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import {
    AlertCircle,
    BookOpen,
    CheckCircle2,
    ChevronDown,
    IdCard,
    Key,
    Users,
} from 'lucide-vue-next';
import { ref } from 'vue';

// --- Data Halaman dari Controller ---
defineProps<{
    title: string;
    description?: string;
}>();

// --- State untuk mengontrol Accordion ---
const activeAccordion = ref<string[]>([]);

function toggleAccordion(value: string) {
    const index = activeAccordion.value.indexOf(value);
    if (index > -1) {
        activeAccordion.value.splice(index, 1);
    } else {
        activeAccordion.value.push(value);
    }
}

// --- Data Peraturan (Ditambah Icon Metadata) ---
const peraturanItems = [
    {
        value: 'item-1',
        trigger: 'PERATURAN PENGUNJUNG',
        icon: Users,
        rules: [
            'Perpustakaan hanya melayani civitas akademika Polban.',
            'Wajib berpakaian sopan dan tidak menggunakan sandal.',
            'Pengunjung perpustakaan wajib mengisi komputer data pengunjung.',
            'Menyimpan tas, jaket, jas di dalam loker yang tersedia.',
            'Tidak menyimpan barang berharga di dalam loker (dompet, hp, laptop).',
            'Tidak diperbolehkan membawa makanan dan minuman, merokok kedalam ruang perpustakaan.',
            'Pengunjung perpustakaan harus menjaga ketenangan, tidak membuat kegaduhan dan tidak mengganggu pengunjung yang lain.',
            'Wajib menjaga dan memelihara seluruh koleksi dan fasilitas yang ada di Perpustakaan. Pengunjung yang merusak koleksi dan fasilitas perpustakaan wajib mengganti dengan koleksi dan fasilitas yang sama dan dikenakan sanksi tidak diperbolehkan melakukan peminjaman buku selama 1 semester.',
            'Buku yang telah selesai dibaca harap tidak dikembalikan ke rak buku tapi disimpan di atas meja, disimpan di troli, atau diserahkan kepada petugas.',
            'Petugas tidak bertanggung jawab atas kehilangan barang pengunjung.',
        ],
    },
    {
        value: 'item-2',
        trigger: 'PERATURAN PENGGUNAAN LOKER',
        icon: Key,
        rules: [
            'Barang-barang milik pengunjung (tas, tas laptop, jaket, jaket himpunan, jas, jas lab, jas almameter, baju hangat/sweater, serta makanan dan minuman) diwajibkan untuk disimpan di dalam loker.',
            'Pemakaian loker hanya berlaku ketika jam pelayanan perpustakaan.',
            'Loker hanya boleh diperkenankan bagi yang akan memasuki perpustakaan dan selama ada di perpustakaan.',
            'Tidak diperkenankan meninggalkan barang-barang dalam loker apabila telah meninggalkan perpustakaan.',
            'Pengunjung wajib menjaga kebersihan loker.',
            'Pengunjung dilarang membuat coretan, merusak, dan atau membawa kunci loker.',
            'Pengunjung yang menghilangkan, merusak, dan atau mematahkan kunci loker akan dikenakan sanksi.',
        ],
    },
    {
        value: 'item-3',
        trigger: 'PERATURAN PEMINJAMAN BUKU',
        icon: BookOpen,
        rules: [
            'Peminjam adalah Pemustaka yaitu mahasiswa, dosen atau karyawan Polban yang status keanggotaan perpustakaannya aktif.',
            'Anggota yang status keanggotaannya tidak aktif dapat memperpanjang keanggotaannya terlebih dahulu.',
            'Tidak diperkenankan meminjam buku dengan menggunakan kartu anggota mahasiswa lain.',
            'Jumlah buku yang dapat dipinjam maksimal 2 (dua) buku untuk mahasiswa dan 3 (tiga) buku untuk dosen, dengan periode peminjaman selama satu (satu) minggu.',
            'Perpanjangan periode peminjaman buku hanya dapat dilakukan 1 (satu) kali.',
            'Keterlambatan pengembalian buku dikenakan denda.',
            'Kerusakan dan kehilangan buku yang dipinjam menjadi tanggung jawab peminjam. Kerusakan buku yang terjadi pada saat pengembalian (sobek, basah, coretan, kotor, terbakar) akan dikenakan sanksi berupa tidak diperbolehkan melakukan peminjaman buku selama 1 semester dan penggantian buku.',
            'Penggantian buku yang hilang atau rusak diganti dengan buku yang sama. Apabila tidak ada sesuai buku aslinya maka diganti dengan judul buku yang sama edisi terbaru, diganti dengan subyek buku yang sama, diganti dengan jumlah halamannya sama atau lebih banyak, atau diganti dengan tahun terbit buku sama atau terbaru dengan buku yang dihilangkan.',
        ],
    },
    {
        value: 'item-4',
        trigger: 'PERATURAN KEANGGOTAAN PERPUSTAKAAN',
        icon: IdCard,
        rules: [
            'Anggota adalah pemustaka yaitu mahasiswa, dosen atau karyawan Polban yang terdaftar dalam basis data keanggotaan perpustakaan.',
            'Mahasiswa Baru sudah otomatis menjadi anggota perpustakaan.',
            'Mahasiswa yang status keanggotaannya tidak aktif, dapat memperpanjang keanggotaannya dengan memperlihatkan bukti pembayaran UKT semester berjalan.',
            'Keanggotaan perpustakaan bagi mahasiswa berlaku per semester. Maka di setiap awal semester baru setelah melakukan pembayaran UKT harus memperpanjang keanggotaan perpustakaan.',
            'Keanggotaan perpustakaan bagi dosen dan karyawan Polban berlaku per semester. Maka di setiap awal semester baru harus melakukan daftar ulang keanggotaan perpustakaan.',
        ],
    },
];

const breadcrumb = [{ label: 'Profil' }, { label: 'Peraturan Perpustakaan' }];
</script>

<template>
    <UserAppLayout :title="title" :breadcrumb="breadcrumb" :page="true">
        <!-- Background decoration (Consistent Theme) -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute top-0 right-0 h-[600px] w-[600px] rounded-full bg-[#99cc33]/5 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-[500px] w-[500px] rounded-full bg-gray-100 blur-3xl"
            ></div>
        </div>

        <div class="relative container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <!-- Alert Box -->
            <div class="mx-auto mb-10 max-w-4xl">
                <div
                    class="flex items-start gap-4 rounded-2xl border border-[#99cc33]/20 bg-[#99cc33]/10 p-5 shadow-sm"
                >
                    <div
                        class="shrink-0 rounded-full bg-white p-2 text-[#99cc33] shadow-sm"
                    >
                        <AlertCircle class="h-6 w-6" />
                    </div>
                    <div>
                        <h3 class="mb-1 font-bold text-slate-800">
                            Pemberitahuan Penting
                        </h3>
                        <p
                            class="text-sm leading-relaxed text-slate-600 sm:text-base"
                        >
                            Setiap pengguna perpustakaan wajib mematuhi
                            peraturan yang berlaku demi kenyamanan, ketertiban,
                            dan kelancaran layanan bersama.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Accordion Container -->
            <div class="mx-auto max-w-4xl space-y-4">
                <div
                    v-for="item in peraturanItems"
                    :key="item.value"
                    class="group overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:border-[#99cc33]/30 hover:shadow-md"
                    :class="{
                        'border-[#99cc33]/40 ring-2 ring-[#99cc33]/20':
                            activeAccordion.includes(item.value),
                    }"
                >
                    <!-- Tombol Accordion -->
                    <button
                        type="button"
                        @click="toggleAccordion(item.value)"
                        :aria-expanded="activeAccordion.includes(item.value)"
                        class="flex w-full items-center justify-between px-6 py-5 text-left focus:outline-none"
                    >
                        <div class="flex items-center gap-4">
                            <!-- Icon Container -->
                            <div
                                class="rounded-xl p-2.5 transition-colors duration-300"
                                :class="
                                    activeAccordion.includes(item.value)
                                        ? 'bg-[#99cc33] text-white'
                                        : 'bg-slate-50 text-slate-500 group-hover:bg-[#99cc33]/10 group-hover:text-[#99cc33]'
                                "
                            >
                                <component :is="item.icon" class="h-6 w-6" />
                            </div>
                            <span
                                class="text-lg font-bold tracking-tight transition-colors duration-300"
                                :class="
                                    activeAccordion.includes(item.value)
                                        ? 'text-[#99cc33]'
                                        : 'text-slate-700 group-hover:text-slate-900'
                                "
                            >
                                {{ item.trigger }}
                            </span>
                        </div>

                        <ChevronDown
                            class="h-5 w-5 text-slate-400 transition-transform duration-300"
                            :class="{
                                'rotate-180 text-[#99cc33]':
                                    activeAccordion.includes(item.value),
                            }"
                        />
                    </button>

                    <!-- Konten Accordion -->
                    <transition name="accordion">
                        <div
                            v-show="activeAccordion.includes(item.value)"
                            class="overflow-hidden border-t border-slate-100 bg-slate-50/50"
                        >
                            <div class="px-6 py-6 sm:px-8 sm:py-8">
                                <ul class="space-y-4">
                                    <li
                                        v-for="(rule, index) in item.rules"
                                        :key="index"
                                        class="group/rule flex items-start gap-3"
                                    >
                                        <div class="mt-0.5 shrink-0">
                                            <CheckCircle2
                                                class="h-5 w-5 text-[#99cc33] opacity-60 transition-opacity group-hover/rule:opacity-100"
                                            />
                                        </div>
                                        <span
                                            class="text-justify text-[0.95rem] leading-relaxed text-slate-600 transition-colors group-hover/rule:text-slate-800"
                                        >
                                            {{ rule }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </UserAppLayout>
</template>

<style scoped>
/* Transisi accordion yang dioptimalkan */
.accordion-enter-active,
.accordion-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    max-height: 1000px; /* Arbitrary large height */
    opacity: 1;
}

.accordion-enter-from,
.accordion-leave-to {
    max-height: 0;
    opacity: 0;
}
</style>
