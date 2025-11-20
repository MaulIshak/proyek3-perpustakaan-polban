<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    AlertTriangle,
    BookOpen,
    CheckCircle,
    ChevronRight,
    Clock,
    Download,
    Eye,
    Filter,
    Search,
    Trash2,
    XCircle,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

import { computed } from 'vue';

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
        minimumFractionDigits: 0,
    }).format(number);
};

// Logic Status Color (Tetap Semantic tapi disesuaikan stylenya nanti)
const getStatusColor = (status) => {
    switch (status) {
        case 'pending':
            return 'bg-blue-50 text-blue-700 border-blue-200';
        case 'approved':
            return 'bg-[#f3fff3] text-[#0f3800] border-[#99cc33]'; // Custom Green Theme
        case 'rejected':
            return 'bg-red-50 text-red-700 border-red-200';
        default:
            return 'bg-gray-50 text-gray-700';
    }
};

const updateStatus = (id, newStatus) => {
    router.patch(
        `/admin/usulan-buku/${id}/status`,
        {
            status: newStatus,
        },
        {
            preserveScroll: true,
        },
    );
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
        },
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
        router.get(
            '/admin/usulan-buku',
            {
                search: newSearch,
                status: newStatus === 'all' ? null : newStatus,
            },
            {
                preserveState: true,
                replace: true,
            },
        );
    }, 300);
});

const exportUrl = computed(() => {
    const params = new URLSearchParams();

    if (search.value) {
        params.append('search', search.value);
    }

    if (statusFilter.value && statusFilter.value !== 'all') {
        params.append('status', statusFilter.value);
    }

    // Return URL lengkap dengan query string
    return `/admin/usulan-buku/export?${params.toString()}`;
});
</script>

<template>
    <Head title="Manajemen Usulan Buku" />

    <div class="min-h-screen bg-[#f3fff3] p-6 font-sans text-gray-800 lg:p-8">
        <div
            class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
        >
            <div>
                <h1 class="text-2xl font-bold text-[#0f3800]">
                    Manajemen Usulan Buku
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola dan validasi usulan pembelian buku dari pengguna.
                </p>
            </div>
            <a
                :href="exportUrl || ''"
                target="_blank"
                class="flex transform items-center gap-2 rounded-lg bg-[#00637b] px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-[#0f3800] hover:shadow-lg"
            >
                <Download class="h-4 w-4" />
                Export Excel
            </a>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
            <div
                class="group relative flex items-center justify-between overflow-hidden rounded-xl border border-[#99cc33]/30 bg-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div class="relative z-10">
                    <div
                        class="mb-1 text-xs font-bold tracking-wider text-gray-500 uppercase"
                    >
                        Total Usulan
                    </div>
                    <div class="text-3xl font-bold text-[#0f3800]">
                        {{ stats.total }}
                    </div>
                </div>
                <div class="rounded-lg bg-[#f3fff3] p-3 text-[#00637b]">
                    <BookOpen class="h-6 w-6" />
                </div>
            </div>

            <div
                class="flex items-center justify-between rounded-xl border border-blue-100 bg-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div>
                    <div
                        class="mb-1 text-xs font-bold tracking-wider text-gray-500 uppercase"
                    >
                        Diproses
                    </div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ stats.pending }}
                    </div>
                </div>
                <div class="rounded-lg bg-blue-50 p-3 text-blue-600">
                    <Clock class="h-6 w-6" />
                </div>
            </div>

            <div
                class="flex items-center justify-between rounded-xl border border-[#99cc33]/50 bg-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div>
                    <div
                        class="mb-1 text-xs font-bold tracking-wider text-gray-500 uppercase"
                    >
                        Disetujui
                    </div>
                    <div class="text-3xl font-bold text-[#00637b]">
                        {{ stats.approved }}
                    </div>
                </div>
                <div class="rounded-lg bg-[#f3fff3] p-3 text-[#99cc33]">
                    <CheckCircle class="h-6 w-6" />
                </div>
            </div>

            <div
                class="flex items-center justify-between rounded-xl border border-red-100 bg-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div>
                    <div
                        class="mb-1 text-xs font-bold tracking-wider text-gray-500 uppercase"
                    >
                        Ditolak
                    </div>
                    <div class="text-3xl font-bold text-red-500">
                        {{ stats.rejected }}
                    </div>
                </div>
                <div class="rounded-lg bg-red-50 p-3 text-red-500">
                    <XCircle class="h-6 w-6" />
                </div>
            </div>
        </div>

        <div
            class="mb-6 flex flex-col items-center justify-between gap-4 rounded-xl border border-[#99cc33]/20 bg-white p-4 shadow-sm md:flex-row"
        >
            <div class="relative w-full md:w-96">
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                >
                    <Search class="h-4 w-4 text-gray-400" />
                </div>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari nama pengusul, judul buku..."
                    class="w-full rounded-lg border border-gray-200 bg-[#f3fff3]/30 py-2.5 pr-4 pl-10 text-sm transition outline-none hover:bg-white focus:border-[#99cc33] focus:ring-2 focus:ring-[#99cc33]"
                />
            </div>
            <div class="flex w-full items-center gap-2 md:w-auto">
                <div class="relative w-full md:w-auto">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                    >
                        <Filter class="h-4 w-4 text-[#00637b]" />
                    </div>
                    <select
                        v-model="statusFilter"
                        class="w-full cursor-pointer rounded-lg border border-gray-200 bg-white py-2.5 pr-10 pl-10 text-sm font-medium text-gray-700 outline-none hover:bg-gray-50 focus:border-[#00637b] focus:ring-2 focus:ring-[#00637b] md:w-auto"
                    >
                        <option value="all">Semua Status</option>
                        <option value="pending">Diproses</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-xl border border-[#99cc33]/30 bg-white shadow-md"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#00637b]">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-white uppercase"
                            >
                                Nama Pengusul
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-white uppercase"
                            >
                                Judul Buku
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-white uppercase"
                            >
                                Pengarang
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-white uppercase"
                            >
                                ISBN/Tahun
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-white uppercase"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold tracking-wider text-white uppercase"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr
                            v-for="proposal in proposals.data"
                            :key="proposal.id"
                            class="group transition-colors duration-150 hover:bg-[#f3fff3]"
                        >
                            <td class="max-w-[180px] px-6 py-4">
                                <div
                                    class="truncate font-bold text-[#0f3800]"
                                    :title="proposal.nama_pengusul"
                                >
                                    {{ proposal.nama_pengusul }}
                                </div>
                                <div
                                    class="mt-1 flex items-center gap-1 truncate text-xs text-gray-500"
                                >
                                    <span
                                        class="rounded bg-gray-100 px-1.5 py-0.5"
                                        >{{ proposal.nim }}</span
                                    >
                                    <span>{{ proposal.prodi }}</span>
                                </div>
                            </td>

                            <td class="max-w-[220px] px-6 py-4">
                                <div
                                    class="truncate font-bold text-[#00637b]"
                                    :title="proposal.title"
                                >
                                    {{ proposal.title }}
                                </div>
                                <div
                                    class="mt-1 truncate text-xs font-normal text-gray-500"
                                    :title="proposal.publisher"
                                >
                                    {{ proposal.publisher }}
                                </div>
                            </td>

                            <td class="max-w-[150px] px-6 py-4">
                                <div
                                    class="truncate text-gray-700"
                                    :title="proposal.author"
                                >
                                    {{ proposal.author }}
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-gray-700"
                            >
                                <div class="font-mono text-xs">
                                    {{ proposal.isbn }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ proposal.year }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="relative w-32">
                                    <select
                                        :value="proposal.status"
                                        @change="
                                            updateStatus(
                                                proposal.id,
                                                $event.target.value,
                                            )
                                        "
                                        :class="[
                                            'w-full cursor-pointer appearance-none rounded-md border py-1.5 pr-8 pl-3 text-xs font-bold shadow-sm transition focus:ring-2 focus:ring-offset-1 focus:outline-none',
                                            getStatusColor(proposal.status),
                                        ]"
                                    >
                                        <option value="pending">
                                            Diproses
                                        </option>
                                        <option value="approved">
                                            Disetujui
                                        </option>
                                        <option value="rejected">
                                            Ditolak
                                        </option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 opacity-60"
                                    >
                                        <ChevronRight
                                            class="h-3 w-3 rotate-90"
                                        />
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        @click="openDetailModal(proposal)"
                                        class="rounded-full border border-[#00637b]/20 bg-[#f3fff3] p-2 text-[#00637b] shadow-sm transition hover:bg-[#00637b] hover:text-white"
                                        title="Lihat Detail"
                                    >
                                        <Eye class="h-4 w-4" />
                                    </button>

                                    <button
                                        v-if="
                                            proposal.status === 'rejected' ||
                                            proposal.status === 'approved'
                                        "
                                        @click="confirmDelete(proposal.id)"
                                        class="rounded-full border border-red-200 bg-red-50 p-2 text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white"
                                        title="Hapus"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="proposals.data.length === 0">
                            <td
                                colspan="6"
                                class="bg-[#f3fff3]/30 px-6 py-12 text-center text-gray-500"
                            >
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <BookOpen
                                        class="mb-2 h-10 w-10 text-gray-300"
                                    />
                                    <p>
                                        Tidak ada data usulan buku yang
                                        ditemukan.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                v-if="proposals.links.length > 3"
                class="flex flex-col items-center justify-between gap-4 border-t border-gray-200 bg-white px-6 py-4 sm:flex-row"
            >
                <div class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-bold text-[#0f3800]">{{
                        proposals.from
                    }}</span>
                    -
                    <span class="font-bold text-[#0f3800]">{{
                        proposals.to
                    }}</span>
                    dari
                    <span class="font-bold text-[#0f3800]">{{
                        proposals.total
                    }}</span>
                    data
                </div>
                <div class="flex gap-1">
                    <Component
                        :is="link.url ? Link : 'span'"
                        v-for="(link, key) in proposals.links"
                        :key="key"
                        :href="link.url"
                        v-html="link.label"
                        class="rounded-md border px-3 py-1.5 text-sm font-medium transition-all duration-200"
                        :class="[
                            link.active
                                ? 'border-[#00637b] bg-[#00637b] text-white shadow-md'
                                : 'border-gray-200 bg-white text-gray-600 hover:border-[#99cc33] hover:bg-[#f3fff3] hover:text-[#00637b]',
                            !link.url
                                ? 'cursor-not-allowed bg-gray-50 opacity-50'
                                : '',
                        ]"
                    />
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div
                v-if="isDetailModalOpen"
                class="relative z-[9999]"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
            >
                <div
                    @click="closeDetailModal"
                    class="fixed inset-0 bg-[#0f3800]/50 backdrop-blur-sm transition-opacity"
                ></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center sm:p-0"
                    >
                        <div
                            class="relative transform overflow-hidden rounded-xl border-t-4 border-[#99cc33] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl"
                        >
                            <div
                                class="flex items-center justify-between border-b border-[#99cc33]/20 bg-[#f3fff3] px-6 py-4"
                            >
                                <h3
                                    class="flex items-center gap-2 text-lg font-bold text-[#0f3800]"
                                >
                                    <BookOpen class="h-5 w-5 text-[#00637b]" />
                                    Detail Usulan Buku
                                </h3>
                                <button
                                    @click="closeDetailModal"
                                    class="text-gray-400 transition hover:text-[#00637b]"
                                >
                                    <XCircle class="h-6 w-6" />
                                </button>
                            </div>

                            <div class="px-6 py-6" v-if="selectedProposal">
                                <div
                                    class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2"
                                >
                                    <div class="col-span-full">
                                        <h4
                                            class="mb-3 border-b border-[#99cc33]/20 pb-1 text-xs font-bold tracking-wider text-[#00637b] uppercase"
                                        >
                                            Informasi Pengusul
                                        </h4>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Nama</label
                                        >
                                        <p
                                            class="text-sm font-semibold text-[#0f3800]"
                                        >
                                            {{ selectedProposal.nama_pengusul }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >NIM/NIP</label
                                        >
                                        <p
                                            class="text-sm font-semibold text-[#0f3800]"
                                        >
                                            {{ selectedProposal.nim }}
                                        </p>
                                    </div>
                                    <div class="col-span-full">
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Prodi</label
                                        >
                                        <p
                                            class="text-sm font-semibold text-[#0f3800]"
                                        >
                                            {{ selectedProposal.prodi }}
                                        </p>
                                    </div>

                                    <div class="col-span-full mt-2">
                                        <h4
                                            class="mb-3 border-b border-[#99cc33]/20 pb-1 text-xs font-bold tracking-wider text-[#00637b] uppercase"
                                        >
                                            Informasi Buku
                                        </h4>
                                    </div>
                                    <div class="col-span-full">
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Judul</label
                                        >
                                        <p
                                            class="rounded border border-[#99cc33]/20 bg-[#f3fff3] p-2 text-base font-bold text-[#0f3800]"
                                        >
                                            {{ selectedProposal.title }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Pengarang</label
                                        >
                                        <p
                                            class="text-sm font-medium text-gray-800"
                                        >
                                            {{ selectedProposal.author }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Penerbit</label
                                        >
                                        <p
                                            class="text-sm font-medium text-gray-800"
                                        >
                                            {{ selectedProposal.publisher }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Harga Estimasi</label
                                        >
                                        <p
                                            class="text-sm font-bold text-[#00637b]"
                                        >
                                            {{
                                                formatRupiah(
                                                    selectedProposal.price,
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <div class="col-span-full">
                                        <label
                                            class="mb-1 block text-xs text-gray-500"
                                            >Alasan Pembelian</label
                                        >
                                        <div
                                            class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-justify text-sm leading-relaxed text-gray-600 italic"
                                        >
                                            "{{
                                                selectedProposal.reason || '-'
                                            }}"
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex justify-end border-t border-gray-200 bg-gray-50 px-6 py-4"
                            >
                                <button
                                    type="button"
                                    @click="closeDetailModal"
                                    class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:text-[#00637b]"
                                >
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div
                v-if="isDeleteModalOpen"
                class="relative z-[9999]"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
            >
                <div
                    @click="closeDeleteModal"
                    class="fixed inset-0 bg-[#0f3800]/50 backdrop-blur-sm transition-opacity"
                ></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center sm:p-0"
                    >
                        <div
                            class="relative transform overflow-hidden rounded-lg border-t-4 border-red-500 bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md"
                        >
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                    >
                                        <AlertTriangle
                                            class="h-6 w-6 text-red-600"
                                        />
                                    </div>
                                    <div
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                                    >
                                        <h3
                                            class="text-lg leading-6 font-bold text-gray-900"
                                        >
                                            Hapus Usulan Buku
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Apakah Anda yakin ingin
                                                menghapus data ini?
                                                <span
                                                    class="mt-2 block rounded border border-red-100 bg-red-50 p-2 font-semibold text-red-600"
                                                    >Tindakan ini tidak dapat
                                                    dibatalkan.</span
                                                >
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="gap-2 bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                            >
                                <button
                                    type="button"
                                    @click="deleteProposal"
                                    :disabled="isDeleting"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm transition hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none disabled:opacity-50 sm:w-auto sm:text-sm"
                                >
                                    {{
                                        isDeleting
                                            ? 'Menghapus...'
                                            : 'Ya, Hapus'
                                    }}
                                </button>
                                <button
                                    type="button"
                                    @click="closeDeleteModal"
                                    :disabled="isDeleting"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:ring-2 focus:ring-[#00637b] focus:ring-offset-2 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm"
                                >
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
