<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
// Kita ganti Card dengan div biasa agar tidak error jika komponen tidak ada
// import { Card, CardContent } from '@/components/ui/card'; 

import { 
    CalendarClock, 
    CheckCircle2,
    Book,
    Plus,
    Trash2,
    X,
    Save
} from 'lucide-vue-next';

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
    deadline?: string; // Field baru dari database
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
    deadline: '' as string // Field untuk menampung input tanggal
});

// --- HELPER: Initials ---
const getInitials = (name: string) => {
    return name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
};

// Helper Format Tanggal untuk Tabel (Indo)
const formatDeadline = (dateString: string) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    }).replace('.', ':');
};

// --- HELPER: Quick Date Actions (Untuk Modal) ---
const setQuickDate = (daysToAdd: number) => {
    const date = new Date();
    date.setDate(date.getDate() + daysToAdd);
    date.setHours(9, 0, 0, 0); // Default jam 09:00 pagi
    
    // Format ke string YYYY-MM-DDTHH:mm untuk input html
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    form.deadline = `${year}-${month}-${day}T${hours}:${minutes}`;
};

// --- ACTIONS ---

// Buka Modal Setuju
const openApproveModal = (booking: Booking) => { 
    selectedBooking.value = booking; 
    
    // Default: Set ke BESOK jam 09:00
    setQuickDate(1); 

    showApproveModal.value = true; 
};

const openRejectModal = (booking: Booking) => { selectedBooking.value = booking; rejectionReason.value = ''; showRejectModal.value = true; };
const openCancelModal = (booking: Booking) => { 
    selectedBooking.value = booking; 
    form.reset(); // [PERBAIKAN] Reset form agar deadline kosong
    form.clearErrors(); 
    showCancelModal.value = true; 
};
const openDeleteModal = (booking: Booking) => { selectedBooking.value = booking; showDeleteModal.value = true; };

// --- SUBMIT FUNCTIONS ---

const submitApprove = () => {
    if (!selectedBooking.value) return;
    form.status = 'approved'; 
    form.rejection_reason = null;
    
    // Kirim data (deadline sudah ada di form)
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { 
        onSuccess: () => showApproveModal.value = false 
    });
};

const submitReject = () => {
    if (!selectedBooking.value) return;
    form.status = 'rejected'; form.rejection_reason = rejectionReason.value;
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { onSuccess: () => showRejectModal.value = false });
};

const submitCancel = () => {
    if (!selectedBooking.value) return;
    
    form.status = 'cancelled'; 
    form.rejection_reason = null;
    form.deadline = ''; // [PERBAIKAN] Pastikan deadline kosong saat dikirim
    
    form.patch(`/admin/booking-buku/${selectedBooking.value.id}/status`, { 
        onSuccess: () => showCancelModal.value = false 
    });
};

const submitDelete = () => {
    if (!selectedBooking.value) return;
    form.delete(`/admin/booking-buku/${selectedBooking.value.id}`, { onSuccess: () => showDeleteModal.value = false });
};

// Helper Visual Style
const getStatusStyles = (status: string) => {
    switch(status) {
        case 'approved': return 'bg-[#f0fdf4] text-[#16a34a] ring-1 ring-[#16a34a]/20';
        case 'rejected': return 'bg-[#fef2f2] text-[#dc2626] ring-1 ring-[#dc2626]/20';
        case 'cancelled': return 'bg-gray-50 text-gray-600 ring-1 ring-gray-200';
        default: return 'bg-[#fffbeb] text-[#b45309] ring-1 ring-[#b45309]/20';
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
        
        <div class="rounded-xl shadow-lg border border-gray-100 overflow-hidden bg-white">
            
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
                                        <Book class="h-10 w-10 text-gray-300" />
                                    </div>
                                    <p class="text-base font-medium text-gray-500">Belum ada data booking masuk.</p>
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
                                                <span>📧 {{ item.email }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-[#7da825] font-medium">
                                                <span>📞 {{ item.whatsapp }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <div class="space-y-1">
                                    <div class="font-bold text-gray-800 leading-snug text-[15px]">{{ item.judul_buku }}</div>
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                        <span>{{ item.pengarang }}</span>
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
                                
                                <div v-if="item.status === 'approved' && item.deadline" class="mt-3 bg-[#f0fdf4] p-2.5 rounded-lg border border-[#16a34a]/20 w-full max-w-[200px]">
                                    <div class="flex gap-1.5 mb-1 items-center">
                                        <CalendarClock class="h-3.5 w-3.5 text-[#16a34a]" />
                                        <p class="text-[10px] font-bold text-[#15803d] uppercase tracking-wider">Batas Ambil</p>
                                    </div>
                                    <p class="text-xs text-gray-700 font-semibold pl-5">
                                        {{ formatDeadline(item.deadline) }}
                                    </p>
                                </div>

                                <div v-if="item.status === 'rejected'" class="mt-3 bg-red-50 p-3 rounded-lg border border-red-100 w-full max-w-[200px]">
                                    <div class="flex gap-1.5 mb-1">
                                        <svg class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        <p class="text-[10px] font-bold text-red-700 uppercase">Alasan Penolakan</p>
                                    </div>
                                    <p class="text-xs text-gray-600 italic line-clamp-3">"{{ item.rejection_reason }}"</p>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-middle text-right">
                                <div class="flex flex-col gap-2 items-end justify-center h-full">
                                    
                                    <div v-if="item.status === 'pending'" class="flex gap-2">
                                        <Button @click="openApproveModal(item)" size="sm" class="bg-[#99cc33] hover:bg-[#88b82d] text-white h-9 px-4 text-xs shadow-md rounded-lg">
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
                                        class="group/delete text-gray-300 hover:text-red-600 p-2 transition-colors"
                                        title="Hapus Data"
                                    >
                                        <Trash2 class="h-5 w-5" />
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <Teleport to="body">
            <div v-if="showApproveModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
                
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm flex flex-col border-t-[6px] border-[#99cc33] animate-in fade-in zoom-in duration-200">
                    
                    <div class="p-6 text-center">
                        <div class="bg-[#f0fdf4] p-4 rounded-full inline-flex mb-4 shadow-sm border border-[#99cc33]/20">
                            <CheckCircle2 class="h-8 w-8 text-[#99cc33]" />
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800">Setujui Peminjaman?</h3>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                            Tentukan batas waktu pengambilan buku <strong>{{ selectedBooking?.judul_buku }}</strong>.
                        </p>

                        <div class="mt-6 text-left">
                            <label class="block text-xs font-bold text-[#99cc33] mb-2 uppercase tracking-wide">
                                Batas Pengambilan (Tgl & Jam)
                            </label>
                            
                            <input 
                                type="datetime-local" 
                                v-model="form.deadline"
                                class="w-full text-sm font-semibold text-gray-700 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:bg-white focus:ring-2 focus:ring-[#99cc33] focus:border-transparent transition-all shadow-sm cursor-pointer"
                                required
                            >

                            <p v-if="form.errors.deadline" class="text-[10px] text-red-500 mt-1 font-bold ml-1">
                                {{ form.errors.deadline }}
                            </p>

                            <div class="flex gap-2 mt-3 overflow-x-auto pb-1 no-scrollbar">
                                <button @click="setQuickDate(1)" type="button" class="text-[10px] font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-[#99cc33] hover:text-white transition-colors border border-gray-200 whitespace-nowrap">Besok</button>
                                <button @click="setQuickDate(2)" type="button" class="text-[10px] font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-[#99cc33] hover:text-white transition-colors border border-gray-200 whitespace-nowrap">Lusa</button>
                                <button @click="setQuickDate(3)" type="button" class="text-[10px] font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-[#99cc33] hover:text-white transition-colors border border-gray-200 whitespace-nowrap">3 Hari</button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-b-2xl border-t border-gray-100 flex gap-3">
                        <Button 
                            variant="outline" 
                            @click="showApproveModal = false" 
                            class="flex-1 rounded-xl border-gray-200 text-gray-600 hover:bg-white h-10"
                        >
                            Batal
                        </Button>
                        <Button 
                            @click="submitApprove" 
                            :disabled="form.processing" 
                            class="flex-1 bg-[#99cc33] hover:bg-[#88b82d] text-white rounded-xl shadow-lg shadow-[#99cc33]/20 h-10 font-bold transition-all"
                        >
                            {{ form.processing ? '...' : 'Konfirmasi' }}
                        </Button>
                    </div>

                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div v-if="showRejectModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md animate-in fade-in zoom-in duration-300 overflow-hidden border-t-[6px] border-red-500">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex items-center gap-3">
                        <div class="bg-red-100 p-2 rounded-lg">
                            <X class="h-5 w-5 text-red-600" />
                        </div>
                        <h3 class="text-lg font-bold text-red-900">Tolak Permintaan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
                            <textarea 
                                v-model="rejectionReason"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none transition-all"
                                placeholder="Contoh: Buku sedang dipinjam..."
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
                        <Trash2 v-if="showDeleteModal" class="h-8 w-8 text-gray-600" />
                        <X v-else class="h-8 w-8 text-gray-600" />
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