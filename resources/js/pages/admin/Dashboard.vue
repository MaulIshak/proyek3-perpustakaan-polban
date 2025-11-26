<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import {
    Newspaper,
    Megaphone,
    Image as ImageIcon,
    BookOpen,
    LibraryBig,
    Activity,
    Clock,
    ArrowUpRight,
    MoreHorizontal,
    Users,
    Calendar
} from 'lucide-vue-next';
import { computed } from 'vue';

// Define Layout
defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, {
            title: 'Dashboard',
            subTitle: 'Ringkasan aktivitas dan statistik terbaru perpustakaan',
        }, { default: () => page }),
});

// --- PROPS DARI CONTROLLER ---
// PERBAIKAN: Menggunakan withDefaults agar tidak error jika props undefined
const props = withDefaults(defineProps<{
    stats?: {
        berita: { total: number; trend: string };
        pengumuman: { total: number; trend: string };
        galeri: { total: number; trend: string };
        booking: { total: number; trend: string };
    };
    recentActivities?: Array<{
        id: string | number;
        type: string;
        title: string;
        status: string;
        time_raw: string; // ISO String
        icon_type: string; // String mapping untuk icon
        bg_icon: string;
    }>;
}>(), {
    stats: () => ({
        berita: { total: 0, trend: '-' },
        pengumuman: { total: 0, trend: '-' },
        galeri: { total: 0, trend: '-' },
        booking: { total: 0, trend: '-' }
    }),
    recentActivities: () => []
});

// --- HELPER FUNCTIONS ---
// Mapping string icon name dari backend ke komponen Lucide
const iconMap: Record<string, any> = {
    Newspaper,
    Megaphone,
    Image: ImageIcon,
    BookOpen,
    Users
};

// Fungsi 'Time Ago' sederhana
function timeAgo(dateString: string) {
    if (!dateString) return '-'; // Guard clause
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + " tahun lalu";

    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + " bulan lalu";

    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + " hari lalu";

    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + " jam lalu";

    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + " menit lalu";

    return "Baru saja";
}

// Re-construct stats array agar cocok dengan loop di template
// Optional chaining (?.) ditambahkan untuk keamanan ekstra
const statsDisplay = computed(() => [
    {
        label: 'Total Berita',
        value: props.stats?.berita?.total ?? 0,
        trend: props.stats?.berita?.trend ?? '-',
        icon: Newspaper,
        class: 'bg-gradient-to-br from-emerald-50 to-white border-emerald-100 text-emerald-800',
        iconBg: 'bg-emerald-500 text-white',
        trendColor: 'text-emerald-600'
    },
    {
        label: 'Pengumuman',
        value: props.stats?.pengumuman?.total ?? 0,
        trend: props.stats?.pengumuman?.trend ?? '-',
        icon: Megaphone,
        class: 'bg-gradient-to-br from-sky-50 to-white border-sky-100 text-sky-800',
        iconBg: 'bg-sky-500 text-white',
        trendColor: 'text-sky-600'
    },
    {
        label: 'Foto Galeri',
        value: props.stats?.galeri?.total ?? 0,
        trend: props.stats?.galeri?.trend ?? '-',
        icon: ImageIcon,
        class: 'bg-gradient-to-br from-amber-50 to-white border-amber-100 text-amber-800',
        iconBg: 'bg-amber-500 text-white',
        trendColor: 'text-amber-600'
    },
    {
        label: 'Booking Pending',
        value: props.stats?.booking?.total ?? 0,
        trend: props.stats?.booking?.trend ?? '-',
        icon: BookOpen,
        class: 'bg-gradient-to-br from-violet-50 to-white border-violet-100 text-violet-800',
        iconBg: 'bg-violet-500 text-white',
        trendColor: 'text-violet-600'
    },
]);

// Data Aksi Cepat (Tetap Static karena ini menu)
const quickActions = [
    { label: 'Buat Berita', href: '/admin/berita/create', icon: Newspaper, color: 'text-white', bg: 'bg-gradient-to-br from-emerald-400 to-emerald-600' },
    { label: 'Buat Pengumuman', href: '/admin/pengumuman/create', icon: Megaphone, color: 'text-white', bg: 'bg-gradient-to-br from-sky-400 to-sky-600' },
    { label: 'Upload Foto', href: '/admin/galeri', icon: ImageIcon, color: 'text-white', bg: 'bg-gradient-to-br from-amber-400 to-amber-600' }, // Fixed link
    { label: 'Cek Booking', href: '/admin/booking-buku', icon: Calendar, color: 'text-white', bg: 'bg-gradient-to-br from-violet-400 to-violet-600' }, // Fixed link
    { label: 'Usulan Buku', href: '/admin/usulan-buku', icon: LibraryBig, color: 'text-white', bg: 'bg-gradient-to-br from-rose-400 to-rose-600' }, // Fixed link
];

</script>

<template>
    <div class="space-y-8 font-sans text-slate-600">

        <!-- 1. Stats Section (Dynamic) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div
                v-for="(stat, index) in statsDisplay"
                :key="index"
                class="group relative overflow-hidden rounded-2xl border p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                :class="stat.class"
            >
                <div class="flex items-center gap-4 relative z-10">
                    <!-- Icon Bubble -->
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl shadow-sm transition-transform group-hover:scale-110 group-hover:rotate-3" :class="stat.iconBg">
                        <component :is="stat.icon" class="h-7 w-7" />
                    </div>

                    <!-- Text Content -->
                    <div>
                        <p class="text-sm font-bold opacity-80 uppercase tracking-wider">{{ stat.label }}</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-3xl font-black">{{ stat.value }}</h3>
                        </div>
                        <p class="text-xs font-medium mt-1" :class="stat.trendColor">
                            {{ stat.trend }}
                        </p>
                    </div>
                </div>

                <!-- Decorative Big Icon -->
                <component
                    :is="stat.icon"
                    class="absolute -bottom-6 -right-6 h-32 w-32 opacity-10 transform -rotate-12 group-hover:scale-110 transition-transform duration-500"
                />
            </div>
        </div>

        <!-- 2. Quick Actions (Static Menus) -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <Activity class="w-5 h-5 text-[#99cc33]" />
                    Aksi Cepat
                </h3>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <Link
                    v-for="(action, index) in quickActions"
                    :key="index"
                    :href="action.href"
                    class="group relative flex flex-col items-center justify-center gap-3 rounded-2xl p-6 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden"
                >
                    <!-- Background Gradient -->
                    <div class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity" :class="action.bg"></div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full shadow-md transition-transform duration-300 group-hover:scale-110"
                        :class="action.bg + ' ' + action.color"
                    >
                        <component :is="action.icon" class="h-6 w-6" />
                    </div>
                    <span class="text-sm font-bold text-slate-700 group-hover:text-slate-900 text-center z-10">
                        {{ action.label }}
                    </span>
                </Link>
            </div>
        </div>

        <!-- 3. Recent Activity (Dynamic Aggregation) -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                <!-- Header Card -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 rounded-t-2xl">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <Clock class="w-5 h-5 text-slate-400" />
                        Aktivitas Terkini
                    </h3>
                    <!-- <button class="text-slate-400 hover:text-[#99cc33] transition-colors p-1 hover:bg-slate-100 rounded-full">
                        <MoreHorizontal class="w-5 h-5" />
                    </button> -->
                </div>

                <!-- List Content -->
                <div class="p-2">
                    <!-- Guard clause: gunakan length dari props.recentActivities yang sudah diduafultkan -->
                    <div v-if="recentActivities && recentActivities.length > 0" class="divide-y divide-slate-50">
                        <div
                            v-for="(activity, index) in recentActivities"
                            :key="index"
                            class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-xl transition-all group"
                        >
                            <!-- Icon Indicator -->
                            <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0" :class="activity.bg_icon">
                                <component :is="iconMap[activity.icon_type] || Activity" class="h-5 w-5" />
                            </div>

                            <!-- Content -->
                            <div class="flex-grow min-w-0">
                                <div class="flex justify-between items-start mb-0.5">
                                    <h4 class="text-sm font-bold text-slate-700 truncate pr-4 group-hover:text-[#99cc33] transition-colors">
                                        {{ activity.title }}
                                    </h4>
                                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ timeAgo(activity.time_raw) }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="font-medium">{{ activity.type }}</span>
                                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                    <span
                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500"
                                    >
                                        {{ activity.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="py-12 flex flex-col items-center justify-center text-center text-slate-400">
                        <div class="bg-slate-50 p-4 rounded-full mb-3">
                            <Activity class="w-8 h-8 opacity-50" />
                        </div>
                        <p class="text-sm font-medium">Belum ada aktivitas terbaru.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
