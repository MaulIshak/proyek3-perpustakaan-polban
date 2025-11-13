<script setup lang="ts">
import PengumumanCard from '@/components/PengumumanCard.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';

const pengumumanList = [
    {
        id: 1,
        title: 'Libur Perpustakaan pada Hari Raya Imlek 2025',
        content:
            '<p>UPT Perpustakaan POLBAN akan tutup pada tanggal 29 Januari 2025 dalam rangka perayaan Imlek.</p>',
        date: '2025-01-20',
    },
    {
        id: 2,
        title: 'Perubahan Jam Operasional Perpustakaan Selama Ujian Akhir Semester',
        content:
            '<p>Selama periode ujian akhir semester, jam operasional perpustakaan akan diperpanjang hingga pukul 22.00 WIB.</p>',
        date: '2025-01-15',
    },
    {
        id: 2,
        title: 'Perubahan Jam Operasional Perpustakaan Selama Ujian Akhir Semester',
        content:
            '<p>Selama periode ujian akhir semester, jam operasional perpustakaan akan diperpanjang hingga pukul 22.00 WIB.</p>',
        date: '2025-01-15',
    },
];

const breadcrumb = [{ label: 'Informasi' }, { label: 'Pengumuman' }];
</script>
<template>
    <UserAppLayout :page="true" :breadcrumb="breadcrumb" title="Pengumuman">
        <div class="mx-auto mt-10 mb-8 max-w-7xl px-4 sm:px-6 lg:px-8">
            <PengumumanCard
                v-for="pengumuman in pengumumanList"
                :key="pengumuman.id"
                :title="pengumuman.title"
                :content="pengumuman.content"
                :date="pengumuman.date"
            />
        </div>
    </UserAppLayout>
</template>
