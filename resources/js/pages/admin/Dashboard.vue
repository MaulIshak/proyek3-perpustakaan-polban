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

// Define Layout
defineOptions({
    layout: (h: any, page: any) =>
        h(AdminLayout, {
            title: 'Dashboard',
            subTitle: 'Ringkasan aktivitas dan statistik terbaru perpustakaan',
        }, { default: () => page }),
});

// Data Statistik (Colorful Gradients)
const stats = [
    {
        label: 'Total Berita',
        value: '24',
        trend: '+3 bulan ini',
        icon: Newspaper,
        // Gradient Hijau Segar
        class: 'bg-gradient-to-br from-emerald-50 to-white border-emerald-100 text-emerald-800',
        iconBg: 'bg-emerald-500 text-white',
        trendColor: 'text-emerald-600'
    },
    {
        label: 'Pengumuman',
        value: '12',
        trend: '+2 minggu ini',
        icon: Megaphone,
        // Gradient Biru Langit
        class: 'bg-gradient-to-br from-sky-50 to-white border-sky-100 text-sky-800',
        iconBg: 'bg-sky-500 text-white',
        trendColor: 'text-sky-600'
    },
    {
        label: 'Foto Galeri',
        value: '156',
        trend: '+15 foto baru',
        icon: ImageIcon,
        // Gradient Kuning/Amber Hangat
        class: 'bg-gradient-to-br from-amber-50 to-white border-amber-100 text-amber-800',
        iconBg: 'bg-amber-500 text-white',
        trendColor: 'text-amber-600'
    },
    {
        label: 'Booking Buku',
        value: '8',
        trend: 'Menunggu konfirmasi',
        icon: BookOpen,
        // Gradient Ungu/Violet
        class: 'bg-gradient-to-br from-violet-50 to-white border-violet-100 text-violet-800',
        iconBg: 'bg-violet-500 text-white',
        trendColor: 'text-violet-600'
    },
];

// Data Aksi Cepat (Colorful Cards)
const quickActions = [
    { label: 'Buat Berita', href: '/admin/berita/create', icon: Newspaper, color: 'text-white', bg: 'bg-gradient-to-br from-emerald-400 to-emerald-600' },
    { label: 'Buat Pengumuman', href: '/admin/pengumuman/create', icon: Megaphone, color: 'text-white', bg: 'bg-gradient-to-br from-sky-400 to-sky-600' },
    { label: 'Upload Foto', href: '/admin/gallery/create', icon: ImageIcon, color: 'text-white', bg: 'bg-gradient-to-br from-amber-400 to-amber-600' },
    { label: 'Cek Booking', href: '/admin/booking', icon: Calendar, color: 'text-white', bg: 'bg-gradient-to-br from-violet-400 to-violet-600' },
    { label: 'Usulan Buku', href: '/admin/usulan', icon: LibraryBig, color: 'text-white', bg: 'bg-gradient-to-br from-rose-400 to-rose-600' },
];

// Data Aktivitas (Mock)
const recentActivities = [
    {
        type: 'Berita',
        title: 'Workshop Literasi Digital 2024',
        status: 'Published',
        time: '2 jam lalu',
        icon: Newspaper,
        bgIcon: 'bg-emerald-100 text-emerald-600',
    },
    {
        type: 'Pengumuman',
        title: 'Perpanjangan Waktu Peminjaman',
        status: 'Published',
        time: '5 jam lalu',
        icon: Megaphone,
        bgIcon: 'bg-sky-100 text-sky-600',
    },
    {
        type: 'Galeri',
        title: 'Dokumentasi Kunjungan Industri',
        status: 'Uploaded',
        time: '1 hari lalu',
        icon: ImageIcon,
        bgIcon: 'bg-amber-100 text-amber-600',
    },
    {
        type: 'Booking',
        title: 'Permintaan buku "Clean Code" oleh Mahasiswa',
        status: 'Pending',
        time: '1 hari lalu',
        icon: BookOpen,
        bgIcon: 'bg-violet-100 text-violet-600',
    },
];
</script>

<template>
    <div class="space-y-8 font-sans text-slate-600">

        <!-- 1. Stats Section (Colorful Gradients) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div
                v-for="(stat, index) in stats"
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

        <!-- 2. Quick Actions (Cards with Solid Gradients) -->
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

        <!-- 3. Recent Activity (Placed at Bottom) -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                <!-- Header Card -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 rounded-t-2xl">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <Clock class="w-5 h-5 text-slate-400" />
                        Aktivitas Terkini
                    </h3>
                    <button class="text-slate-400 hover:text-[#99cc33] transition-colors p-1 hover:bg-slate-100 rounded-full">
                        <MoreHorizontal class="w-5 h-5" />
                    </button>
                </div>

                <!-- List Content -->
                <div class="p-2">
                    <div v-if="recentActivities.length > 0" class="divide-y divide-slate-50">
                        <div
                            v-for="(activity, index) in recentActivities"
                            :key="index"
                            class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-xl transition-all group"
                        >
                            <!-- Icon Indicator -->
                            <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0" :class="activity.bgIcon">
                                <component :is="activity.icon" class="h-5 w-5" />
                            </div>

                            <!-- Content -->
                            <div class="flex-grow min-w-0">
                                <div class="flex justify-between items-start mb-0.5">
                                    <h4 class="text-sm font-bold text-slate-700 truncate pr-4 group-hover:text-[#99cc33] transition-colors">
                                        {{ activity.title }}
                                    </h4>
                                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ activity.time }}</span>
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

                            <!-- Arrow Action -->
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity text-slate-400">
                                <ArrowUpRight class="w-4 h-4" />
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

                <!-- Footer Card -->
                <div class="p-3 border-t border-slate-100 bg-slate-50/30 rounded-b-2xl">
                    <Link href="#" class="flex items-center justify-center gap-2 w-full py-2 text-xs font-bold text-slate-500 hover:text-[#99cc33] transition-colors group">
                        Lihat Semua Aktivitas
                        <ArrowUpRight class="w-3 h-3 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                    </Link>
                </div>
            </div>
        </div>

    </div>
</template>
