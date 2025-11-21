<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

// --- TYPES (Sesuaikan dengan nama kolom DB / snake_case dari Laravel) ---
interface Booking {
    id: number;
    nama_lengkap: string;
    nim_nip: string;
    email: string;
    whatsapp: string;
    judul_buku: string;
    pengarang: string;
    booking_date?: string; // Bisa null jika tidak ada di db
    created_at: string;
    status: 'pending' | 'approved' | 'rejected' | 'cancelled';
    rejection_reason?: string;
}

const props = defineProps<{
    bookings: Booking[];
}>();

// --- STATE MODALS ---
const selectedBooking = ref<Booking | null>(null);
const rejectionReason = ref('');

// Kontrol visibilitas modal
const showApproveModal = ref(false);
const showRejectModal = ref(false);
const showCancelModal = ref(false);
const showDeleteModal = ref(false);

// Form Inertia
const form = useForm({
    status: '',
    rejection_reason: '' as string | null,
});

// --- HELPER FUNCTIONS ---

// Buka Modal Setuju
const openApproveModal = (booking: Booking) => {
    selectedBooking.value = booking;
    showApproveModal.value = true;
};

// Buka Modal Tolak
const openRejectModal = (booking: Booking) => {
    selectedBooking.value = booking;
    rejectionReason.value = '';
    showRejectModal.value = true;
};

// Buka Modal Batal
const openCancelModal = (booking: Booking) => {
    selectedBooking.value = booking;
    showCancelModal.value = true;
};

// Buka Modal Hapus
const openDeleteModal = (booking: Booking) => {
    selectedBooking.value = booking;
    showDeleteModal.value = true;
};

// --- SUBMIT ACTIONS ---

const submitApprove = () => {
    if (!selectedBooking.value) return;
    form.status = 'approved';
    form.rejection_reason = null;
    
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, {
        onSuccess: () => showApproveModal.value = false,
    });
};

const submitReject = () => {
    if (!selectedBooking.value) return;
    form.status = 'rejected';
    form.rejection_reason = rejectionReason.value;

    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, {
        onSuccess: () => showRejectModal.value = false,
    });
};

const submitCancel = () => {
    if (!selectedBooking.value) return;
    form.status = 'cancelled';
    form.rejection_reason = null;

    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, {
        onSuccess: () => showCancelModal.value = false,
    });
};

const submitDelete = () => {
    if (!selectedBooking.value) return;
    form.delete(`/admin/booking-buku/${selectedBooking.value.id}`, {
        onSuccess: () => showDeleteModal.value = false,
    });
};

// Helper Warna Status
const getStatusColor = (status: string) => {
    switch(status) {
        case 'approved': return 'bg-green-100 text-green-800 border-green-200';
        case 'rejected': return 'bg-red-100 text-red-800 border-red-200';
        case 'cancelled': return 'bg-gray-100 text-gray-800 border-gray-200';
        default: return 'bg-yellow-100 text-yellow-800 border-yellow-200';
    }
};

const getStatusLabel = (status: string) => {
     switch(status) {
        case 'approved': return 'Disetujui';
        case 'rejected': return 'Ditolak';
        case 'cancelled': return 'Dibatalkan';
        default: return 'Menunggu';
    }
};

defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, { title: 'Booking Buku', subTitle: 'Kelola Peminjaman Buku' }, { default: () => page })
});
</script>

<template>
    <div class="space-y-6 relative">
        
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Permintaan Booking</h1>
        </div>

        <!-- TABEL DATA -->
        <Card class="shadow-md border-t-4 border-green-500 overflow-hidden">
            <CardContent class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase font-semibold border-b">
                            <tr>
                                <th class="px-6 py-4 text-center w-[50px]">No</th>
                                <th class="px-6 py-4">Peminjam</th>
                                <th class="px-6 py-4">Buku</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                             <tr v-if="bookings.length === 0">
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    Belum ada permintaan booking.
                                </td>
                            </tr>

                            <tr v-for="(item, index) in bookings" :key="item.id" class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-medium text-gray-500">{{ index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ item.nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">{{ item.nim_nip }}</div>
                                    <div class="text-xs text-green-600 flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        {{ item.whatsapp }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ item.judul_buku }}</div>
                                    <div class="text-xs text-gray-500">Pengarang: {{ item.pengarang }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Tgl Request: {{ new Date(item.created_at).toLocaleDateString() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span 
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shadow-sm"
                                        :class="getStatusColor(item.status)"
                                    >
                                        {{ getStatusLabel(item.status) }}
                                    </span>
                                    
                                    <div v-if="item.status === 'rejected'" class="text-xs text-red-500 mt-2 italic bg-red-50 p-1 rounded border border-red-100 max-w-[200px]">
                                        "{{ item.rejection_reason }}"
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 flex-wrap max-w-[200px] ml-auto">
                                        
                                        <!-- Aksi untuk Status PENDING -->
                                        <template v-if="item.status === 'pending'">
                                            <Button @click="openApproveModal(item)" size="sm" class="bg-green-600 hover:bg-green-700 text-white h-8 text-xs shadow-sm">
                                                Setuju
                                            </Button>
                                            <Button @click="openRejectModal(item)" size="sm" variant="destructive" class="bg-red-500 hover:bg-red-600 h-8 text-xs shadow-sm">
                                                Tolak
                                            </Button>
                                        </template>

                                        <!-- Aksi untuk Status APPROVED -->
                                        <template v-if="item.status === 'approved'">
                                             <Button @click="openCancelModal(item)" size="sm" variant="outline" class="border-orange-300 text-orange-600 hover:bg-orange-50 h-8 text-xs">
                                                Batal Ambil
                                            </Button>
                                        </template>

                                        <!-- Tombol Hapus (Selalu Ada) -->
                                        <button 
                                            @click="openDeleteModal(item)" 
                                            class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded hover:bg-red-50"
                                            title="Hapus Data"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </CardContent>
        </Card>

        <!-- ================================================== -->
        <!-- KUMPULAN MODAL (DENGAN TELEPORT & Z-INDEX TINGGI) -->
        <!-- ================================================== -->

        <!-- 1. MODAL SETUJU -->
        <Teleport to="body">
            <div v-if="showApproveModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 animate-in fade-in zoom-in duration-200">
                    <div class="text-center">
                        <div class="bg-green-100 p-3 rounded-full inline-block mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Setujui Peminjaman?</h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Pastikan buku <strong>{{ selectedBooking?.judul_buku }}</strong> tersedia.
                        </p>
                        <div class="flex gap-3 mt-6 justify-center">
                            <Button variant="outline" @click="showApproveModal = false">Batal</Button>
                            <Button @click="submitApprove" :disabled="form.processing" class="bg-green-600 hover:bg-green-700 text-white">
                                Ya, Setujui
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- 2. MODAL TOLAK (DENGAN ALASAN) -->
        <Teleport to="body">
            <div v-if="showRejectModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-md animate-in fade-in zoom-in duration-200">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex items-center gap-3 rounded-t-xl">
                        <div class="bg-red-100 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-900">Tolak Permintaan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                            <textarea 
                                v-model="rejectionReason"
                                class="w-full rounded-md border border-gray-300 p-3 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none"
                                placeholder="Contoh: Buku hilang, Sedang diperbaiki..."
                                rows="3"
                            ></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <Button variant="outline" @click="showRejectModal = false">Batal</Button>
                            <Button @click="submitReject" :disabled="form.processing" class="bg-red-600 hover:bg-red-700 text-white">
                                Kirim Penolakan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- 3. MODAL BATAL AMBIL -->
        <Teleport to="body">
            <div v-if="showCancelModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 text-center animate-in fade-in zoom-in duration-200">
                    <div class="bg-orange-100 p-3 rounded-full inline-block mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Batalkan Booking?</h3>
                    <p class="text-gray-500 text-sm mt-2">
                        Peminjam tidak mengambil buku? Status akan diubah menjadi <strong>Dibatalkan</strong>.
                    </p>
                    <div class="flex gap-3 mt-6 justify-center">
                        <Button variant="outline" @click="showCancelModal = false">Kembali</Button>
                        <Button @click="submitCancel" :disabled="form.processing" class="bg-orange-500 hover:bg-orange-600 text-white">
                            Ya, Batalkan
                        </Button>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- 4. MODAL HAPUS DATA -->
        <Teleport to="body">
            <div v-if="showDeleteModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 animate-in fade-in zoom-in duration-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-100 p-2 rounded-full shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Hapus Data?</h3>
                            <p class="text-gray-500 text-sm mt-1">
                                Data booking atas nama <strong>{{ selectedBooking?.nama_lengkap }}</strong> akan dihapus permanen.
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <Button variant="outline" @click="showDeleteModal = false">Batal</Button>
                        <Button @click="submitDelete" :disabled="form.processing" class="bg-red-600 hover:bg-red-700 text-white">
                            Hapus Permanen
                        </Button>
                    </div>
                </div>
            </div>
        </Teleport>

    </div>
</template>