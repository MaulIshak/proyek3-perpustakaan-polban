<script setup>
import { ref, watch } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Judul Halaman',
                subTitle: 'Subjudul Halaman',
            },
            { default: () => page },
        ),
});

const props = defineProps({
    proposals: Object,
    filters: Object,
    stats: Object,
});

const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || 'all');

// --- FORMATTER ---
const formatDate = (dateString) => {
    if (!dateString) return '-';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

const formatRupiah = (number) => {
    if (!number) return '-';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-blue-50 text-blue-700 border-blue-200';
        case 'approved': return 'bg-green-50 text-green-700 border-green-200';
        case 'rejected': return 'bg-red-50 text-red-700 border-red-200';
        default: return 'bg-gray-50 text-gray-700';
    }
};

const updateStatus = (id, newStatus) => {
    router.patch(`/admin/usulan-buku/${id}/status`, {
        status: newStatus
    }, {
        preserveScroll: true
    });
};

// --- LOGIKA MODAL DELETE ---
const isDeleteModalOpen = ref(false);
const proposalToDelete = ref(null);
const isDeleting = ref(false);

const confirmDelete = (id) => {
    proposalToDelete.value = id;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    proposalToDelete.value = null;
};

const deleteProposal = () => {
    if (!proposalToDelete.value) return;
    isDeleting.value = true;
    
    router.delete(`/admin/usulan-buku/${proposalToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeDeleteModal();
            isDeleting.value = false;
        },
        onError: () => {
            isDeleting.value = false;
            closeDeleteModal();
            console.error('Gagal menghapus data');
        }
    });
};

// --- LOGIKA MODAL DETAIL ---
const isDetailModalOpen = ref(false);
const selectedProposal = ref(null);

const openDetailModal = (proposal) => {
    selectedProposal.value = proposal;
    isDetailModalOpen.value = true;
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    selectedProposal.value = null;
};

// --- WATCHER FILTER ---
let timeout = null;
watch([search, statusFilter], ([newSearch, newStatus]) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get('/admin/usulan-buku', { 
            search: newSearch, 
            status: newStatus === 'all' ? null : newStatus 
        }, { 
            preserveState: true, 
            replace: true 
        });
    }, 300);
});
</script>

<template>
    <Head title="Manajemen Usulan Buku" />

    <div class="min-h-screen bg-gray-50 p-8 font-sans text-gray-800">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
             <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Usulan Buku</h1>
                <p class="text-gray-500 mt-1">Kelola usulan pembelian buku dari pengguna</p>
            </div>
             <a href="/admin/usulan-buku/export" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition shadow-sm text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export Excel
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
             <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="text-sm text-gray-500 mb-1 font-medium">Total Usulan</div>
                <div class="text-3xl font-bold text-gray-900">{{ stats.total }}</div>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="text-sm text-gray-500 mb-1 font-medium">Diproses</div>
                <div class="text-3xl font-bold text-blue-600">{{ stats.pending }}</div>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="text-sm text-gray-500 mb-1 font-medium">Disetujui</div>
                <div class="text-3xl font-bold text-emerald-600">{{ stats.approved }}</div>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="text-sm text-gray-500 mb-1 font-medium">Ditolak</div>
                <div class="text-3xl font-bold text-red-500">{{ stats.rejected }}</div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input v-model="search" type="text" placeholder="Cari nama pengusul, judul buku..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
            </div>
            <div class="flex items-center gap-2">
                <select v-model="statusFilter" class="pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white cursor-pointer">
                    <option value="all">Semua Status</option>
                    <option value="pending">Diproses</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">Nama Pengusul</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">Judul Buku</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">Pengarang</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">ISBN</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">Tahun</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-left">Alasan</th>
                            <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="proposal in proposals.data" :key="proposal.id" class="hover:bg-gray-50 transition group">
                            
                            <td class="px-6 py-4 max-w-[180px]">
                                <div class="font-semibold text-gray-900 truncate" :title="proposal.nama_pengusul">
                                    {{ proposal.nama_pengusul }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1 truncate">
                                    {{ proposal.nim }} - {{ proposal.prodi }}
                                </div>
                            </td>

                            <td class="px-6 py-4 max-w-[220px]">
                                <div class="text-gray-900 font-medium truncate" :title="proposal.title">
                                    {{ proposal.title }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1 font-normal truncate" :title="proposal.publisher">
                                    {{ proposal.publisher }}
                                </div>
                            </td>

                            <td class="px-6 py-4 max-w-[150px]">
                                <div class="text-gray-900 truncate" :title="proposal.author">
                                    {{ proposal.author }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                                {{ proposal.isbn }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                                {{ proposal.year }}
                            </td>
                            
                            <td class="px-6 py-4 max-w-[150px]">
                                <div class="text-gray-900 truncate" :title="proposal.reason">
                                    {{ proposal.reason || '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-3 items-center">
                                    
                                    <div class="relative w-full">
                                        <select 
                                            :value="proposal.status"
                                            @change="updateStatus(proposal.id, $event.target.value)"
                                            :class="[
                                                'w-full appearance-none pl-3 pr-8 py-1.5 rounded-md text-xs font-bold border cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-1 transition shadow-sm',
                                                getStatusColor(proposal.status)
                                            ]"
                                        >
                                            <option value="pending">Diproses</option>
                                            <option value="approved">Disetujui</option>
                                            <option value="rejected">Ditolak</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 opacity-60" :class="proposal.status === 'pending' ? 'text-blue-700' : (proposal.status === 'approved' ? 'text-green-700' : 'text-red-700')">
                                            <svg class="h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>

                                    <div class="flex gap-2 w-full justify-center">
                                        <button 
                                            @click="openDetailModal(proposal)"
                                            class="flex-1 px-2 py-1.5 text-xs font-medium text-blue-600 border border-blue-200 rounded-md hover:bg-blue-50 hover:border-blue-300 transition text-center"
                                        >
                                            Detail
                                        </button>

                                        <button 
                                            v-if="proposal.status === 'rejected' || proposal.status === 'approved'"
                                            @click="confirmDelete(proposal.id)"
                                            class="flex-1 px-2 py-1.5 text-xs font-medium text-red-600 border border-red-200 rounded-md hover:bg-red-50 hover:border-red-300 transition text-center"
                                        >
                                            Hapus
                                        </button>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr v-if="proposals.data.length === 0">
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                Tidak ada data usulan buku.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="proposals.links.length > 3" class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-gray-500 text-sm">
                    Menampilkan <span class="font-medium">{{ proposals.from }}</span> sampai <span class="font-medium">{{ proposals.to }}</span> dari <span class="font-medium">{{ proposals.total }}</span> data
                </div>
                <div class="flex gap-1">
                    <Component 
                        :is="link.url ? Link : 'span'"
                        v-for="(link, key) in proposals.links" 
                        :key="key"
                        :href="link.url"
                        v-html="link.label"
                        class="px-3 py-1 text-sm rounded-md border transition"
                        :class="[
                            link.active 
                                ? 'bg-blue-600 text-white border-blue-600 shadow-sm' 
                                : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50',
                            !link.url ? 'opacity-50 cursor-not-allowed bg-gray-50' : ''
                        ]"
                    />
                </div>
            </div>
        </div>

        <Teleport to="body">
            
            <div v-if="isDetailModalOpen" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                
                <div 
                    @click="closeDetailModal" 
                    class="fixed inset-0 bg-black/50 transition-opacity" 
                ></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        
                        <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                            
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-900">Detail Usulan Buku</h3>
                                <button @click="closeDetailModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="px-6 py-6" v-if="selectedProposal">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="col-span-full"><h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 border-b pb-1">Informasi Pengusul</h4></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Nama</label><p class="text-sm font-medium text-gray-900 whitespace-normal break-words">{{ selectedProposal.nama_pengusul }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">NIM/NIP</label><p class="text-sm font-medium text-gray-900 whitespace-normal break-words">{{ selectedProposal.nim }}</p></div>
                                    <div class="col-span-full"><label class="block text-xs text-gray-500 mb-1">Prodi</label><p class="text-sm font-medium text-gray-900 whitespace-normal break-words">{{ selectedProposal.prodi }}</p></div>

                                    <div class="col-span-full mt-2"><h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 border-b pb-1">Informasi Buku</h4></div>
                                    <div class="col-span-full"><label class="block text-xs text-gray-500 mb-1">Judul</label><p class="text-base font-bold text-gray-900 whitespace-normal break-words">{{ selectedProposal.title }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Pengarang</label><p class="text-sm font-medium text-gray-900 whitespace-normal break-words">{{ selectedProposal.author }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Penerbit</label><p class="text-sm font-medium text-gray-900 whitespace-normal break-words">{{ selectedProposal.publisher }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Harga</label><p class="text-sm font-medium text-gray-900">{{ formatRupiah(selectedProposal.price) }}</p></div>
                                    <div class="col-span-full"><label class="block text-xs text-gray-500 mb-1">Alasan</label><div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-700 border border-gray-100 whitespace-normal break-words text-justify">{{ selectedProposal.reason || '-' }}</div></div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                <button type="button" @click="closeDetailModal" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="isDeleteModalOpen" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                
                <div 
                    @click="closeDeleteModal" 
                    class="fixed inset-0 bg-black/50 transition-opacity"
                ></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Hapus Usulan Buku</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Apakah Anda yakin ingin menghapus data ini? <br>
                                                <span class="font-bold text-red-500">Data yang dihapus tidak dapat dikembalikan.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                <button type="button" @click="deleteProposal" :disabled="isDeleting" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto sm:text-sm disabled:opacity-50 transition">
                                    {{ isDeleting ? 'Menghapus...' : 'Ya, Hapus' }}
                                </button>
                                <button type="button" @click="closeDeleteModal" :disabled="isDeleting" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm transition">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Teleport>

    </div>
</template>