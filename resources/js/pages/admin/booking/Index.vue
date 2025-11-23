<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

// --- TYPES ---
interface Booking {
    id: number;
    nama_lengkap: string;
    nim_nip: string;
    email: string;
    whatsapp: string;
    judul_buku: string;
    pengarang: string;
    booking_date?: string;
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

const showApproveModal = ref(false);
const showRejectModal = ref(false);
const showCancelModal = ref(false);
const showDeleteModal = ref(false);

const form = useForm({
    status: '',
    rejection_reason: '' as string | null,
});

// --- HELPER: Get Initials ---
const getInitials = (name: string) => {
    return name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
};

// --- ACTIONS ---
const openApproveModal = (booking: Booking) => { selectedBooking.value = booking; showApproveModal.value = true; };
const openRejectModal = (booking: Booking) => { selectedBooking.value = booking; rejectionReason.value = ''; showRejectModal.value = true; };
const openCancelModal = (booking: Booking) => { selectedBooking.value = booking; showCancelModal.value = true; };
const openDeleteModal = (booking: Booking) => { selectedBooking.value = booking; showDeleteModal.value = true; };

const submitApprove = () => {
    if (!selectedBooking.value) return;
    form.status = 'approved'; form.rejection_reason = null;
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { onSuccess: () => showApproveModal.value = false });
};
const submitReject = () => {
    if (!selectedBooking.value) return;
    form.status = 'rejected'; form.rejection_reason = rejectionReason.value;
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { onSuccess: () => showRejectModal.value = false });
};
const submitCancel = () => {
    if (!selectedBooking.value) return;
    form.status = 'cancelled'; form.rejection_reason = null;
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { onSuccess: () => showCancelModal.value = false });
};
const submitDelete = () => {
    if (!selectedBooking.value) return;
    form.delete(`/admin/booking-buku/${selectedBooking.value.id}`, { onSuccess: () => showDeleteModal.value = false });
};

// Helper Visual
const getStatusStyles = (status: string) => {
    switch(status) {
        case 'approved': return 'bg-[#f0fdf4] text-[#16a34a] ring-1 ring-[#16a34a]/20'; // Hijau Segar
        case 'rejected': return 'bg-[#fef2f2] text-[#dc2626] ring-1 ring-[#dc2626]/20'; // Merah Soft
        case 'cancelled': return 'bg-gray-50 text-gray-600 ring-1 ring-gray-200'; // Abu
        default: return 'bg-[#fffbeb] text-[#b45309] ring-1 ring-[#b45309]/20'; // Kuning (Pending)
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
    <div class="space-y-8 relative font-sans">
        <Card class="rounded-xl shadow-lg border border-gray-100 overflow-hidden bg-white">
            
            <div class="bg-[#99cc33] px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-semibold flex items-center gap-2 text-lg tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    Daftar Permintaan
                </h2>
                <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-md font-medium">
                    Total: {{ bookings.length }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 w-[60px] text-center text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Peminjam</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Buku</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-100 bg-white">
                         <tr v-if="bookings.length === 0">
                            <td colspan="5" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3 border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    </div>
                                    <p class="text-base font-medium text-gray-500">Belum ada data booking masuk.</p>
                                    <p class="text-xs text-gray-400 mt-1">Data akan muncul di sini setelah mahasiswa melakukan request.</p>
                                </div>
                            </td>
                        </tr>

                        <tr v-for="(item, index) in bookings" :key="item.id" class="hover:bg-[#99cc33]/5 transition-colors duration-200 group">
                            <td class="px-6 py-5 text-center font-medium text-gray-400">{{ index + 1 }}</td>
                            
                            <td class="px-6 py-5 align-top">
                                <div class="flex gap-4">
                                    <div class="h-11 w-11 rounded-full bg-[#99cc33] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-md shadow-[#99cc33]/20">
                                        {{ getInitials(item.nama_lengkap) }}
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-bold text-gray-800 text-[15px] leading-tight">{{ item.nama_lengkap }}</div>
                                        
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ item.nim_nip }}
                                        </span>

                                        <div class="flex flex-col gap-1 pt-1">
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                                {{ item.email }}
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-[#7da825] font-medium">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                                {{ item.whatsapp }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <div class="space-y-1">
                                    <div class="font-bold text-gray-800 leading-snug text-[15px]">{{ item.judul_buku }}</div>
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        {{ item.pengarang }}
                                    </div>
                                    <div class="pt-2">
                                        <div class="text-[11px] text-gray-400 uppercase tracking-wide font-semibold">Tanggal Request</div>
                                        <div class="text-sm text-gray-600">
                                            {{ new Date(item.created_at).toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <span 
                                    class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide shadow-sm"
                                    :class="getStatusStyles(item.status)"
                                >
                                    {{ getStatusLabel(item.status) }}
                                </span>
                                
                                <div v-if="item.status === 'rejected'" class="mt-3 bg-red-50 p-3 rounded-lg border border-red-100 w-full max-w-[200px]">
                                    <div class="flex gap-1.5 mb-1">
                                        <svg class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        <p class="text-[10px] font-bold text-red-700 uppercase">Alasan Penolakan</p>
                                    </div>
                                    <p class="text-xs text-gray-600 italic leading-relaxed">"{{ item.rejection_reason }}"</p>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-middle text-right">
                                <div class="flex flex-col gap-2 items-end justify-center h-full">
                                    
                                    <div v-if="item.status === 'pending'" class="flex gap-2">
                                        <Button @click="openApproveModal(item)" size="sm" class="bg-[#99cc33] hover:bg-[#88b82d] text-white h-9 px-4 text-xs shadow-sm transition-all font-semibold rounded-lg">
                                            Setuju
                                        </Button>
                                        <Button @click="openRejectModal(item)" size="sm" variant="outline" class="border-red-200 text-red-600 hover:bg-red-50 h-9 px-4 text-xs hover:border-red-300 rounded-lg">
                                            Tolak
                                        </Button>
                                    </div>

                                    <div v-if="item.status === 'approved'">
                                         <Button @click="openCancelModal(item)" size="sm" variant="outline" class="border-gray-300 text-gray-600 hover:bg-gray-100 h-9 px-4 text-xs rounded-lg">
                                            Batal Ambil
                                        </Button>
                                    </div>

                                    <button 
                                        @click="openDeleteModal(item)" 
                                        class="group/delete flex items-center justify-center h-8 w-8 rounded-full text-gray-300 hover:text-red-600 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100"
                                        title="Hapus Data Permanen"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>

        <Teleport to="body">
            <div v-if="showApproveModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-all">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 animate-in fade-in zoom-in duration-300 border-t-[6px] border-[#99cc33]">
                    <div class="text-center">
                        <div class="bg-[#99cc33]/10 p-4 rounded-full inline-flex mb-4 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#99cc33]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Setujui Peminjaman?</h3>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                            Buku <strong>{{ selectedBooking?.judul_buku }}</strong> akan ditandai siap diambil. Email notifikasi akan dikirim ke mahasiswa.
                        </p>
                        <div class="flex gap-3 mt-8 justify-center">
                            <Button variant="outline" @click="showApproveModal = false" class="rounded-xl border-gray-200">Batal</Button>
                            <Button @click="submitApprove" :disabled="form.processing" class="bg-[#99cc33] hover:bg-[#88b82d] text-white rounded-xl shadow-lg shadow-[#99cc33]/20">
                                {{ form.processing ? 'Memproses...' : 'Ya, Setujui' }}
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="showRejectModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md animate-in fade-in zoom-in duration-300 overflow-hidden border-t-[6px] border-red-500">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex items-center gap-3">
                        <div class="bg-red-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-900">Tolak Permintaan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
                            <textarea 
                                v-model="rejectionReason"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition-all"
                                placeholder="Contoh: Buku sedang dipinjam, hilang, atau rusak..."
                                rows="4"
                            ></textarea>
                        </div>
                        <div class="flex justify-end gap-3 pt-2">
                            <Button variant="outline" @click="showRejectModal = false" class="rounded-xl">Batal</Button>
                            <Button @click="submitReject" :disabled="form.processing" class="bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-md shadow-red-200">
                                Kirim Penolakan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="showCancelModal || showDeleteModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-in fade-in zoom-in duration-300">
                    <div class="bg-gray-100 p-3 rounded-full inline-flex mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ showDeleteModal ? 'Hapus Data Permanen?' : 'Batalkan Transaksi?' }}
                    </h3>
                    <p class="text-gray-500 text-sm mt-2">
                        {{ showDeleteModal ? 'Data yang dihapus tidak bisa dikembalikan.' : 'Status akan diubah menjadi dibatalkan.' }}
                    </p>
                    <div class="flex gap-3 mt-8 justify-center">
                        <Button variant="outline" @click="showCancelModal = false; showDeleteModal = false" class="rounded-xl">Batal</Button>
                        
                        <Button v-if="showDeleteModal" @click="submitDelete" :disabled="form.processing" class="bg-gray-800 hover:bg-black text-white rounded-xl">
                            Ya, Hapus
                        </Button>
                        <Button v-else @click="submitCancel" :disabled="form.processing" class="bg-gray-600 hover:bg-gray-700 text-white rounded-xl">
                            Ya, Batalkan
                        </Button>
                    </div>
                </div>
            </div>
        </Teleport>

    </div>
</template>