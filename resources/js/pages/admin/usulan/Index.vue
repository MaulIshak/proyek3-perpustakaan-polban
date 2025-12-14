<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import {
    BookOpen, CheckCircle, ChevronDown, Clock, Download, Eye, FileText, Filter, MoreHorizontal, Search, Trash2, X, XCircle,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

// Import Components
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import PaginationLink from '@/components/admin/PaginationLink.vue'; // <--- Import Component Pagination Anda
import { useConfirmModal } from '@/composables/userConfirmModal';

defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, {
            title: 'Manajemen Usulan Buku',
            subTitle: 'Kelola daftar permintaan buku baru dari pemustaka',
        }, { default: () => page }),
});

// Props dari Controller
const props = defineProps<{
    proposals: {
        data: any[];
        links: any[]; // Array link pagination
        from: number;
        to: number;
        total: number;
    };
    filters: { search?: string; status?: string; };
    stats: { total: number; pending: number; approved: number; rejected: number; };
}>();

const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || 'all');

// --- FORMATTER ---
const formatDate = (dateString: string) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
};

const formatRupiah = (number: number) => {
    if (!number) return '-';
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
};

const getStatusBadge = (status: string) => {
    switch (status) {
        case 'pending': return { bg: 'bg-blue-50', text: 'text-blue-600', border: 'border-blue-200', icon: Clock };
        case 'approved': return { bg: 'bg-emerald-50', text: 'text-emerald-600', border: 'border-emerald-200', icon: CheckCircle };
        case 'rejected': return { bg: 'bg-red-50', text: 'text-red-600', border: 'border-red-200', icon: XCircle };
        default: return { bg: 'bg-slate-50', text: 'text-slate-600', border: 'border-slate-200', icon: MoreHorizontal };
    }
};

// --- ACTIONS ---
const { open } = useConfirmModal();

const updateStatus = (id: number, newStatus: string) => {
    router.patch(`/admin/usulan-buku/${id}/status`, { status: newStatus }, { preserveScroll: true });
};

const confirmDelete = (proposal: any) => {
    open({
        title: 'Hapus Usulan Buku?',
        message: `Hapus usulan "${proposal.title}" oleh ${proposal.nama_pengusul}?`,
        actionLabel: 'Hapus',
        onConfirm: () => router.delete(`/admin/usulan-buku/${proposal.id}`, { preserveScroll: true }),
    });
};

// --- MODAL DETAIL ---
const isDetailModalOpen = ref(false);
const selectedProposal = ref<any>(null);
const openDetailModal = (p: any) => { selectedProposal.value = p; isDetailModalOpen.value = true; };
const closeDetailModal = () => { isDetailModalOpen.value = false; setTimeout(() => (selectedProposal.value = null), 300); };

// --- WATCHER FILTER ---
watch([search, statusFilter], debounce(([newSearch, newStatus]) => {
    router.get('/admin/usulan-buku', 
        { search: newSearch, status: newStatus === 'all' ? null : newStatus },
        { preserveState: true, replace: true, preserveScroll: true }
    );
}, 300));

const exportUrl = computed(() => {
    const params = new URLSearchParams();
    if (search.value) params.append('search', search.value);
    if (statusFilter.value && statusFilter.value !== 'all') params.append('status', statusFilter.value);
    return `/admin/usulan-buku/export?${params.toString()}`;
});
</script>

<template>
    <Head title="Manajemen Usulan Buku" />

    <div class="space-y-8 font-sans text-slate-600">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#99cc33]/10 text-[#99cc33] transition-transform group-hover:scale-110"><FileText class="h-7 w-7" /></div>
                    <div><p class="text-xs font-bold tracking-wider text-[#99cc33] uppercase opacity-80">Total Usulan</p><h3 class="text-3xl font-black text-slate-800">{{ stats.total }}</h3></div>
                </div>
            </div>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform group-hover:scale-110"><Clock class="h-7 w-7" /></div>
                    <div><p class="text-xs font-bold tracking-wider text-blue-400 uppercase">Diproses</p><h3 class="text-3xl font-black text-blue-700">{{ stats.pending }}</h3></div>
                </div>
            </div>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-transform group-hover:scale-110"><CheckCircle class="h-7 w-7" /></div>
                    <div><p class="text-xs font-bold tracking-wider text-emerald-400 uppercase">Disetujui</p><h3 class="text-3xl font-black text-emerald-700">{{ stats.approved }}</h3></div>
                </div>
            </div>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 transition-transform group-hover:scale-110"><XCircle class="h-7 w-7" /></div>
                    <div><p class="text-xs font-bold tracking-wider text-rose-400 uppercase">Ditolak</p><h3 class="text-3xl font-black text-rose-700">{{ stats.rejected }}</h3></div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm md:flex-row">
            <div class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
                <div class="group relative w-full sm:w-80">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition-colors group-focus-within:text-[#99cc33]"><Search class="h-5 w-5" /></div>
                    <input v-model="search" type="text" placeholder="Cari pengusul, judul..." class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pr-3 pl-10 leading-5 placeholder-slate-400 transition-all focus:border-[#99cc33] focus:bg-white focus:ring-4 focus:ring-[#99cc33]/10 focus:outline-none sm:text-sm" />
                </div>
                <div class="group relative w-full sm:w-48">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-[#99cc33]"><Filter class="h-4 w-4" /></div>
                    <select v-model="statusFilter" class="block w-full cursor-pointer appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pr-8 pl-10 leading-5 transition-all focus:border-[#99cc33] focus:bg-white focus:ring-4 focus:ring-[#99cc33]/10 focus:outline-none sm:text-sm">
                        <option value="all">Semua Status</option>
                        <option value="pending">Diproses</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400"><ChevronDown class="h-4 w-4" /></div>
                </div>
            </div>
            <a :href="exportUrl" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto">
                <Download class="h-4 w-4" /> Export Excel
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase">Pengusul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase">Informasi Buku</th>
                            <th class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold tracking-wider text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="proposal in proposals.data" :key="proposal.id" class="group transition-colors hover:bg-[#f3fff3]/50">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="max-w-[200px] truncate text-sm font-bold text-slate-800" :title="proposal.nama_pengusul">{{ proposal.nama_pengusul }}</span>
                                    <div class="mt-1 flex items-center gap-2">
                                        <span class="rounded border border-slate-200 bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-500">{{ proposal.nim }}</span>
                                        <span class="max-w-[120px] truncate text-xs text-slate-400">{{ proposal.prodi }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex max-w-[250px] flex-col">
                                    <span class="truncate text-sm font-bold text-[#99cc33]" :title="proposal.title">{{ proposal.title }}</span>
                                    <span class="mt-0.5 truncate text-xs text-slate-500">{{ proposal.author }} • {{ proposal.publisher }}</span>
                                    <div class="mt-1 flex items-center gap-2">
                                        <span class="rounded border border-slate-100 bg-slate-50 px-1 font-mono text-[10px] text-slate-400">{{ proposal.isbn }}</span>
                                        <span class="text-[10px] text-slate-400">{{ proposal.year }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ formatDate(proposal.created_at) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative w-36">
                                    <select :value="proposal.status" @change="updateStatus(proposal.id, ($event.target as HTMLSelectElement).value)" class="w-full cursor-pointer appearance-none rounded-lg border py-1.5 pr-8 pl-3 text-xs font-bold shadow-sm transition outline-none focus:ring-2 focus:ring-offset-1" :class="[getStatusBadge(proposal.status).bg, getStatusBadge(proposal.status).text, getStatusBadge(proposal.status).border]">
                                        <option value="pending">Diproses</option>
                                        <option value="approved">Disetujui</option>
                                        <option value="rejected">Ditolak</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 opacity-60"><ChevronDown class="h-3 w-3" /></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    <button @click="openDetailModal(proposal)" class="rounded-lg border border-sky-100 bg-sky-50 p-2 text-sky-600 transition-colors hover:bg-sky-100"><Eye class="h-4 w-4" /></button>
                                    <button @click="confirmDelete(proposal)" class="rounded-lg border border-rose-100 bg-rose-50 p-2 text-rose-600 transition-colors hover:bg-rose-100"><Trash2 class="h-4 w-4" /></button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="proposals.data.length === 0">
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-3 rounded-full bg-slate-50 p-4"><Search class="h-8 w-8 text-slate-400" /></div>
                                    <p class="font-medium text-slate-500">{{ search ? 'Tidak ada data yang cocok.' : 'Belum ada usulan buku baru.' }}</p>
                                    <p v-if="search" class="mt-1 cursor-pointer text-xs font-bold text-[#99cc33] hover:underline" @click="search = ''">Reset Pencarian</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="proposals.data.length > 0" class="flex flex-col items-center justify-between gap-4 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row">
                <div class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-700">{{ proposals.from ?? 0 }}</span> - <span class="font-bold text-slate-700">{{ proposals.to ?? 0 }}</span> dari <span class="font-bold text-slate-700">{{ proposals.total ?? 0 }}</span> data
                </div>
                
                <PaginationLink :links="proposals.links" />
            </div>
        </div>

        <transition name="modal">
            <div v-if="isDetailModalOpen && selectedProposal" class="fixed inset-0 z-[70] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="closeDetailModal"></div>
                <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                    <div class="flex items-center justify-between border-b border-[#99cc33]/20 bg-[#f3fff3] px-6 py-4">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-[#0f3800]"><BookOpen class="h-5 w-5 text-[#99cc33]" /> Detail Usulan Buku</h3>
                        <button @click="closeDetailModal" class="rounded-full bg-white p-1 text-slate-400 shadow-sm transition hover:text-slate-600"><X class="h-5 w-5" /></button>
                    </div>
                    <div class="space-y-6 p-6">
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                            <h4 class="mb-3 border-b border-slate-200 pb-2 text-xs font-bold tracking-wider text-[#99cc33] uppercase">Informasi Pengusul</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><p class="mb-1 text-xs text-slate-400">Nama Lengkap</p><p class="font-bold text-slate-800">{{ selectedProposal.nama_pengusul }}</p></div>
                                <div><p class="mb-1 text-xs text-slate-400">NIM/NIP</p><p class="font-bold text-slate-800">{{ selectedProposal.nim }}</p></div>
                                <div class="col-span-2"><p class="mb-1 text-xs text-slate-400">Program Studi</p><p class="font-bold text-slate-800">{{ selectedProposal.prodi }}</p></div>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-3 border-b border-slate-100 pb-2 text-xs font-bold tracking-wider text-[#99cc33] uppercase">Detail Buku</h4>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:col-span-2"><p class="mb-1 text-xs text-slate-400">Judul Buku</p><p class="rounded-lg border border-[#99cc33]/20 bg-[#f3fff3] p-3 text-lg leading-tight font-bold text-[#0f3800]">{{ selectedProposal.title }}</p></div>
                                <div><p class="mb-1 text-xs text-slate-400">Pengarang</p><p class="font-medium text-slate-700">{{ selectedProposal.author }}</p></div>
                                <div><p class="mb-1 text-xs text-slate-400">Penerbit</p><p class="font-medium text-slate-700">{{ selectedProposal.publisher }}</p></div>
                                <div><p class="mb-1 text-xs text-slate-400">Tahun / ISBN</p><p class="font-medium text-slate-700">{{ selectedProposal.year }} / <span class="font-mono text-xs">{{ selectedProposal.isbn }}</span></p></div>
                                <div><p class="mb-1 text-xs text-slate-400">Estimasi Harga</p><p class="font-bold text-[#99cc33]">{{ formatRupiah(selectedProposal.price) }}</p></div>
                                <div class="md:col-span-2"><p class="mb-1 text-xs text-slate-400">Alasan Usulan</p><div class="rounded-xl border border-slate-100 bg-slate-50 p-4 text-sm leading-relaxed text-slate-600 italic">"{{ selectedProposal.reason || 'Tidak ada alasan yang diberikan.' }}"</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end border-t border-slate-100 bg-slate-50 px-6 py-4">
                        <button @click="closeDetailModal" class="rounded-xl border border-slate-200 bg-white px-6 py-2.5 font-bold text-slate-600 shadow-sm transition-colors hover:bg-slate-100">Tutup</button>
                    </div>
                </div>
            </div>
        </transition>

        <ConfirmModal />
    </div>
</template>

<style scoped>
.modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .transform, .modal-leave-active .transform { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
.modal-enter-from .transform, .modal-leave-to .transform { transform: scale(0.95) translateY(10px); }
</style>