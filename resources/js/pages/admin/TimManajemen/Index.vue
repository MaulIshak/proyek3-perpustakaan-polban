<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import {
    Award,
    Briefcase,
    Pencil,
    Plus,
    Save,
    Trash2,
    UserCircle2,
    Users,
    X,
} from 'lucide-vue-next';
import { ref } from 'vue';

// Import ConfirmModal
import ConfirmModal from '@/components/admin/ConfirmModal.vue';
import { useConfirmModal } from '@/composables/userConfirmModal';

// Layout
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Tim Manajemen',
                subTitle:
                    'Kelola struktur organisasi dan data personil perpustakaan',
            },
            { default: () => page },
        ),
});

// Props
const props = defineProps<{
    manajemen: {
        id_team: string | number;
        nama: string;
        jabatan: string;
        gelar: string;
    }[];
}>();

// State Modal Create/Edit
const showModal = ref(false);
const editMode = ref(false);

// Form Setup
const form = useForm({
    id_team: null as string | number | null,
    nama: '',
    jabatan: '',
    gelar: '',
});

// Use Confirm Modal
const { open } = useConfirmModal();

// --- ACTIONS ---

function openCreateModal() {
    editMode.value = false;
    form.reset();
    form.clearErrors();
    showModal.value = true;
}

function openEditModal(item: (typeof props.manajemen)[0]) {
    editMode.value = true;
    form.id_team = item.id_team;
    form.nama = item.nama;
    form.jabatan = item.jabatan;
    form.gelar = item.gelar;
    form.clearErrors();
    showModal.value = true;
}

function save() {
    const options = {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
        preserveScroll: true,
    };

    if (editMode.value && form.id_team) {
        form.put(`/admin/tim-manajemen/update/${form.id_team}`, options);
    } else {
        form.post('/admin/tim-manajemen/store', options);
    }
}

function deleteItem(item: (typeof props.manajemen)[0]) {
    open({
        title: 'Hapus Anggota Tim?',
        message: `Apakah Anda yakin ingin menghapus "${item.nama}" dari daftar tim manajemen?`,
        actionLabel: 'Hapus',
        // confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
        onConfirm: () => {
            router.delete(`/admin/tim-manajemen/delete/${item.id_team}`, {
                preserveScroll: true,
            });
        },
    });
}
</script>

<template>
    <div class="space-y-8 font-sans text-slate-600">
        <!-- 1. Toolbar -->
        <div
            class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm sm:flex-row"
        >
            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-[#99cc33]/10 p-2 text-[#99cc33]">
                    <Users class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Daftar Personil
                    </h2>
                    <p class="text-xs font-medium text-slate-500">
                        Total {{ props.manajemen.length }} anggota
                    </p>
                </div>
            </div>

            <button
                @click="openCreateModal"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-transparent bg-[#99cc33] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:-translate-y-0.5 hover:bg-[#88b82d] active:translate-y-0 sm:w-auto"
            >
                <Plus class="h-5 w-5" />
                Tambah Anggota
            </button>
        </div>

        <!-- 2. Data Table -->
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50">
                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                            >
                                Nama Lengkap
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                            >
                                Jabatan
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold tracking-wider text-slate-500 uppercase"
                            >
                                Gelar
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-4 text-right text-xs font-bold tracking-wider text-slate-500 uppercase"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <tr
                            v-for="item in manajemen"
                            :key="item.id_team"
                            class="group transition-colors hover:bg-slate-50/80"
                        >
                            <!-- Nama -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#99cc33]/10 text-[#99cc33]"
                                        >
                                            <UserCircle2 class="h-6 w-6" />
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-bold text-slate-800 transition-colors group-hover:text-[#99cc33]"
                                        >
                                            {{ item.nama }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="flex items-center gap-2 text-sm text-slate-600"
                                >
                                    <Briefcase class="h-4 w-4 text-slate-400" />
                                    <span
                                        class="rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700"
                                    >
                                        {{ item.jabatan }}
                                    </span>
                                </div>
                            </td>

                            <!-- Gelar -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="flex items-center gap-2 text-sm text-slate-600"
                                    v-if="item.gelar"
                                >
                                    <Award class="h-4 w-4 text-amber-400" />
                                    {{ item.gelar }}
                                </div>
                                <span
                                    v-else
                                    class="text-xs text-slate-400 italic"
                                    >-</span
                                >
                            </td>

                            <!-- Aksi -->
                            <td
                                class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap"
                            >
                                <div class="flex justify-end gap-2">
                                    <button
                                        @click="openEditModal(item)"
                                        class="rounded-lg border border-amber-100 bg-amber-50 p-2 text-amber-600 transition-colors hover:bg-amber-100"
                                        title="Edit Data"
                                    >
                                        <Pencil class="h-4 w-4" />
                                    </button>
                                    <button
                                        @click="deleteItem(item)"
                                        class="rounded-lg border border-rose-100 bg-rose-50 p-2 text-rose-600 transition-colors hover:bg-rose-100"
                                        title="Hapus Data"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="manajemen.length === 0">
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-slate-400"
                            >
                                <Users
                                    class="mx-auto mb-3 h-12 w-12 text-slate-200"
                                />
                                <p class="text-sm">
                                    Belum ada data tim manajemen.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Modal Form (Create/Edit) -->
         <Teleport to="body">
        <transition name="modal">
            <div
                v-if="showModal"
                class="fixed inset-0 z-[70] flex items-center justify-center p-4"
            >
                <div
                    class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                    @click="showModal = false"
                ></div>

                <div
                    class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                >
                    <!-- Header -->
                    <div
                        class="flex items-center justify-between border-b border-slate-100 bg-slate-50 px-6 py-4"
                    >
                        <h3 class="text-lg font-bold text-slate-800">
                            {{
                                editMode
                                    ? 'Edit Anggota Tim'
                                    : 'Tambah Anggota Baru'
                            }}
                        </h3>
                        <button
                            @click="showModal = false"
                            class="rounded-full bg-white p-1 text-slate-400 shadow-sm transition hover:text-slate-600"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="save" class="space-y-5 p-6">
                        <div>
                            <label
                                class="mb-2 block text-sm font-bold text-slate-700"
                                >Nama Lengkap</label
                            >
                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                >
                                    <UserCircle2 class="h-5 w-5" />
                                </div>
                                <input
                                    v-model="form.nama"
                                    type="text"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                    placeholder="Contoh: Budi Santoso"
                                    required
                                />
                            </div>
                            <p
                                v-if="form.errors.nama"
                                class="mt-1 text-xs text-rose-500"
                            >
                                {{ form.errors.nama }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-sm font-bold text-slate-700"
                                >Jabatan</label
                            >
                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                >
                                    <Briefcase class="h-5 w-5" />
                                </div>
                                <input
                                    v-model="form.jabatan"
                                    type="text"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                    placeholder="Contoh: Kepala Perpustakaan"
                                    required
                                />
                            </div>
                            <p
                                v-if="form.errors.jabatan"
                                class="mt-1 text-xs text-rose-500"
                            >
                                {{ form.errors.jabatan }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-sm font-bold text-slate-700"
                                >Gelar Akademik (Opsional)</label
                            >
                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"
                                >
                                    <Award class="h-5 w-5" />
                                </div>
                                <input
                                    v-model="form.gelar"
                                    type="text"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 pr-4 pl-10 text-slate-700 transition-all outline-none focus:border-[#99cc33] focus:ring-4 focus:ring-[#99cc33]/10"
                                    placeholder="Contoh: S.Sos., M.I.Kom."
                                />
                            </div>
                        </div>

                        <!-- Footer -->
                        <div
                            class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4"
                        >
                            <button
                                type="button"
                                @click="showModal = false"
                                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-600 shadow-sm transition-colors hover:bg-slate-50"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex items-center rounded-xl bg-[#99cc33] px-6 py-2.5 font-bold text-white shadow-lg shadow-[#99cc33]/30 transition-all hover:bg-[#88b82d] disabled:opacity-70"
                            >
                                <Save class="mr-2 h-4 w-4" />
                                {{
                                    editMode
                                        ? 'Simpan Perubahan'
                                        : 'Simpan Data'
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
</Teleport>
        <!-- Komponen Konfirmasi Hapus -->
        <ConfirmModal />
    </div>
</template>

<style scoped>
/* Modal Transition Animation */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}
.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
.modal-enter-active .transform,
.modal-leave-active .transform {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.modal-enter-from .transform,
.modal-leave-to .transform {
    transform: scale(0.95) translateY(10px);
}
</style>
