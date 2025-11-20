<script setup>
import { ref, watch } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { 
    Search, Download, BookOpen, Clock, CheckCircle, XCircle, 
    Eye, Trash2, ChevronLeft, ChevronRight, AlertTriangle, Filter
} from 'lucide-vue-next';

defineOptions({
    layout: (h, page) =>
        h(
            AdminLayout,
            {
                title: 'Manajemen Usulan Buku',
                subTitle: 'Kelola daftar permintaan buku baru dari pemustaka',
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

// Logic Status Color (Tetap Semantic tapi disesuaikan stylenya nanti)
const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-blue-50 text-blue-700 border-blue-200';
        case 'approved': return 'bg-[#f3fff3] text-[#0f3800] border-[#99cc33]'; // Custom Green Theme
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

    <div class="min-h-screen bg-[#f3fff3] p-6 lg:p-8 font-sans text-gray-800">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
             <div>
                <h1 class="text-2xl font-bold text-[#0f3800]">Manajemen Usulan Buku</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola dan validasi usulan pembelian buku dari pengguna.</p>
            </div>
             <a href="/admin/usulan-buku/export" class="bg-[#00637b] hover:bg-[#0f3800] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg text-sm font-semibold transform hover:-translate-y-0.5">
                <Download class="w-4 h-4" />
                Export Excel
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-5 rounded-xl border border-[#99cc33]/30 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="relative z-10">
                    <div class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-wider">Total Usulan</div>
                    <div class="text-3xl font-bold text-[#0f3800]">{{ stats.total }}</div>
                </div>
                <div class="p-3 bg-[#f3fff3] rounded-lg text-[#00637b]">
                    <BookOpen class="w-6 h-6" />
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-blue-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-wider">Diproses</div>
                    <div class="text-3xl font-bold text-blue-600">{{ stats.pending }}</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <Clock class="w-6 h-6" />
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-[#99cc33]/50 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-wider">Disetujui</div>
                    <div class="text-3xl font-bold text-[#00637b]">{{ stats.approved }}</div>
                </div>
                <div class="p-3 bg-[#f3fff3] rounded-lg text-[#99cc33]">
                    <CheckCircle class="w-6 h-6" />
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-red-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-wider">Ditolak</div>
                    <div class="text-3xl font-bold text-red-500">{{ stats.rejected }}</div>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <XCircle class="w-6 h-6" />
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 mb-6 border border-[#99cc33]/20 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="w-4 h-4 text-gray-400" />
                </div>
                <input 
                    v-model="search" 
                    type="text" 
                    placeholder="Cari nama pengusul, judul buku..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-[#f3fff3]/30 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#99cc33] focus:border-[#99cc33] outline-none text-sm transition hover:bg-white"
                >
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Filter class="w-4 h-4 text-[#00637b]" />
                    </div>
                    <select v-model="statusFilter" class="w-full md:w-auto pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#00637b] focus:border-[#00637b] outline-none text-sm bg-white cursor-pointer font-medium text-gray-700 hover:bg-gray-50">
                        <option value="all">Semua Status</option>
                        <option value="pending">Diproses</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#99cc33]/30 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#00637b]">
                        <tr>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-left">Nama Pengusul</th>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-left">Judul Buku</th>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-left">Pengarang</th>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-left">ISBN/Tahun</th>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-left">Status</th>
                            <th class="px-6 py-4 font-bold text-white uppercase tracking-wider text-xs text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="proposal in proposals.data" :key="proposal.id" class="hover:bg-[#f3fff3] transition-colors duration-150 group">
                            
                            <td class="px-6 py-4 max-w-[180px]">
                                <div class="font-bold text-[#0f3800] truncate" :title="proposal.nama_pengusul">
                                    {{ proposal.nama_pengusul }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1 truncate flex items-center gap-1">
                                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">{{ proposal.nim }}</span>
                                    <span>{{ proposal.prodi }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 max-w-[220px]">
                                <div class="text-[#00637b] font-bold truncate" :title="proposal.title">
                                    {{ proposal.title }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1 font-normal truncate" :title="proposal.publisher">
                                    {{ proposal.publisher }}
                                </div>
                            </td>

                            <td class="px-6 py-4 max-w-[150px]">
                                <div class="text-gray-700 truncate" :title="proposal.author">
                                    {{ proposal.author }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                <div class="text-xs font-mono">{{ proposal.isbn }}</div>
                                <div class="text-xs text-gray-500">{{ proposal.year }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="relative w-32">
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
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 opacity-60">
                                        <ChevronRight class="w-3 h-3 rotate-90" />
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2 justify-center">
                                    <button 
                                        @click="openDetailModal(proposal)"
                                        class="p-2 text-[#00637b] bg-[#f3fff3] rounded-full hover:bg-[#00637b] hover:text-white transition shadow-sm border border-[#00637b]/20"
                                        title="Lihat Detail"
                                    >
                                        <Eye class="w-4 h-4" />
                                    </button>

                                    <button 
                                        v-if="proposal.status === 'rejected' || proposal.status === 'approved'"
                                        @click="confirmDelete(proposal.id)"
                                        class="p-2 text-red-600 bg-red-50 rounded-full hover:bg-red-600 hover:text-white transition shadow-sm border border-red-200"
                                        title="Hapus"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="proposals.data.length === 0">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-[#f3fff3]/30">
                                <div class="flex flex-col items-center justify-center">
                                    <BookOpen class="w-10 h-10 text-gray-300 mb-2" />
                                    <p>Tidak ada data usulan buku yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="proposals.links.length > 3" class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                <div class="text-gray-500 text-sm">
                    Menampilkan <span class="font-bold text-[#0f3800]">{{ proposals.from }}</span> - <span class="font-bold text-[#0f3800]">{{ proposals.to }}</span> dari <span class="font-bold text-[#0f3800]">{{ proposals.total }}</span> data
                </div>
                <div class="flex gap-1">
                    <Component 
                        :is="link.url ? Link : 'span'"
                        v-for="(link, key) in proposals.links" 
                        :key="key"
                        :href="link.url"
                        v-html="link.label"
                        class="px-3 py-1.5 text-sm rounded-md border transition-all duration-200 font-medium"
                        :class="[
                            link.active 
                                ? 'bg-[#00637b] text-white border-[#00637b] shadow-md' 
                                : 'bg-white text-gray-600 border-gray-200 hover:bg-[#f3fff3] hover:text-[#00637b] hover:border-[#99cc33]',
                            !link.url ? 'opacity-50 cursor-not-allowed bg-gray-50' : ''
                        ]"
                    />
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div v-if="isDetailModalOpen" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div @click="closeDetailModal" class="fixed inset-0 bg-[#0f3800]/50 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border-t-4 border-[#99cc33]">
                            
                            <div class="bg-[#f3fff3] px-6 py-4 border-b border-[#99cc33]/20 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-[#0f3800] flex items-center gap-2">
                                    <BookOpen class="w-5 h-5 text-[#00637b]" />
                                    Detail Usulan Buku
                                </h3>
                                <button @click="closeDetailModal" class="text-gray-400 hover:text-[#00637b] transition">
                                    <XCircle class="w-6 h-6" />
                                </button>
                            </div>

                            <div class="px-6 py-6" v-if="selectedProposal">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                    
                                    <div class="col-span-full">
                                        <h4 class="text-xs font-bold text-[#00637b] uppercase tracking-wider mb-3 border-b border-[#99cc33]/20 pb-1">Informasi Pengusul</h4>
                                    </div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Nama</label><p class="text-sm font-semibold text-[#0f3800]">{{ selectedProposal.nama_pengusul }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">NIM/NIP</label><p class="text-sm font-semibold text-[#0f3800]">{{ selectedProposal.nim }}</p></div>
                                    <div class="col-span-full"><label class="block text-xs text-gray-500 mb-1">Prodi</label><p class="text-sm font-semibold text-[#0f3800]">{{ selectedProposal.prodi }}</p></div>

                                    <div class="col-span-full mt-2">
                                        <h4 class="text-xs font-bold text-[#00637b] uppercase tracking-wider mb-3 border-b border-[#99cc33]/20 pb-1">Informasi Buku</h4>
                                    </div>
                                    <div class="col-span-full">
                                        <label class="block text-xs text-gray-500 mb-1">Judul</label>
                                        <p class="text-base font-bold text-[#0f3800] bg-[#f3fff3] p-2 rounded border border-[#99cc33]/20">{{ selectedProposal.title }}</p>
                                    </div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Pengarang</label><p class="text-sm font-medium text-gray-800">{{ selectedProposal.author }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Penerbit</label><p class="text-sm font-medium text-gray-800">{{ selectedProposal.publisher }}</p></div>
                                    <div><label class="block text-xs text-gray-500 mb-1">Harga Estimasi</label><p class="text-sm font-bold text-[#00637b]">{{ formatRupiah(selectedProposal.price) }}</p></div>
                                    <div class="col-span-full">
                                        <label class="block text-xs text-gray-500 mb-1">Alasan Pembelian</label>
                                        <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-600 border border-gray-200 italic text-justify leading-relaxed">
                                            "{{ selectedProposal.reason || '-' }}"
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-200">
                                <button type="button" @click="closeDetailModal" class="px-5 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#00637b] transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="isDeleteModalOpen" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div @click="closeDeleteModal" class="fixed inset-0 bg-[#0f3800]/50 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border-t-4 border-red-500">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <AlertTriangle class="h-6 w-6 text-red-600" />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg font-bold leading-6 text-gray-900">Hapus Usulan Buku</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Apakah Anda yakin ingin menghapus data ini?
                                                <span class="block mt-2 text-red-600 font-semibold bg-red-50 p-2 rounded border border-red-100">Tindakan ini tidak dapat dibatalkan.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                <button type="button" @click="deleteProposal" :disabled="isDeleting" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto sm:text-sm disabled:opacity-50 transition">
                                    {{ isDeleting ? 'Menghapus...' : 'Ya, Hapus' }}
                                </button>
                                <button type="button" @click="closeDeleteModal" :disabled="isDeleting" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#00637b] focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm transition">
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