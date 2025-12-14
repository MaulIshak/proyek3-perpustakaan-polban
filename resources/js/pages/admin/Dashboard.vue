<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import {
    Activity,
    BookOpen,
    Calendar,
    Clock,
    Image as ImageIcon,
    LibraryBig,
    Megaphone,
    Newspaper,
    Users,
} from 'lucide-vue-next';
import { computed } from 'vue';

// Define Layout
defineOptions({
    layout: (h: any, page: any) =>
        h(
            AdminLayout,
            {
                title: 'Selamat Datang, Pustakawan',
                subTitle:
                    'Ringkasan aktivitas dan statistik terbaru perpustakaan',
            },
            { default: () => page },
        ),
});

const props = withDefaults(
    defineProps<{
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
    }>(),
    {
        stats: () => ({
            berita: { total: 0, trend: '-' },
            pengumuman: { total: 0, trend: '-' },
            galeri: { total: 0, trend: '-' },
            booking: { total: 0, trend: '-' },
        }),
        recentActivities: () => [],
    },
);

const iconMap: Record<string, any> = {
    Newspaper,
    Megaphone,
    Image: ImageIcon,
    BookOpen,
    Users,
};

// Fungsi 'Time Ago' sederhana
function timeAgo(dateString: string) {
    if (!dateString) return '-'; // Guard clause
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + ' tahun lalu';

    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + ' bulan lalu';

    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + ' hari lalu';

    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + ' jam lalu';

    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + ' menit lalu';

    return 'Baru saja';
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
        trendColor: 'text-emerald-600',
    },
    {
        label: 'Pengumuman',
        value: props.stats?.pengumuman?.total ?? 0,
        trend: props.stats?.pengumuman?.trend ?? '-',
        icon: Megaphone,
        class: 'bg-gradient-to-br from-sky-50 to-white border-sky-100 text-sky-800',
        iconBg: 'bg-sky-500 text-white',
        trendColor: 'text-sky-600',
    },
    {
        label: 'Foto Galeri',
        value: props.stats?.galeri?.total ?? 0,
        trend: props.stats?.galeri?.trend ?? '-',
        icon: ImageIcon,
        class: 'bg-gradient-to-br from-amber-50 to-white border-amber-100 text-amber-800',
        iconBg: 'bg-amber-500 text-white',
        trendColor: 'text-amber-600',
    },
    {
        label: 'Booking Pending',
        value: props.stats?.booking?.total ?? 0,
        trend: props.stats?.booking?.trend ?? '-',
        icon: BookOpen,
        class: 'bg-gradient-to-br from-violet-50 to-white border-violet-100 text-violet-800',
        iconBg: 'bg-violet-500 text-white',
        trendColor: 'text-violet-600',
    },
]);

// Data Aksi Cepat (Tetap Static karena ini menu)
const quickActions = [
    {
        label: 'Buat Berita',
        href: '/admin/berita/create',
        icon: Newspaper,
        color: 'text-white',
        bg: 'bg-gradient-to-br from-emerald-400 to-emerald-600',
    },
    {
        label: 'Buat Pengumuman',
        href: '/admin/pengumuman/create',
        icon: Megaphone,
        color: 'text-white',
        bg: 'bg-gradient-to-br from-sky-400 to-sky-600',
    },
    {
        label: 'Upload Foto',
        href: '/admin/galeri',
        icon: ImageIcon,
        color: 'text-white',
        bg: 'bg-gradient-to-br from-amber-400 to-amber-600',
    }, // Fixed link
    {
        label: 'Cek Booking',
        href: '/admin/booking-buku',
        icon: Calendar,
        color: 'text-white',
        bg: 'bg-gradient-to-br from-violet-400 to-violet-600',
    }, // Fixed link
    {
        label: 'Usulan Buku',
        href: '/admin/usulan-buku',
        icon: LibraryBig,
        color: 'text-white',
        bg: 'bg-gradient-to-br from-rose-400 to-rose-600',
    }, // Fixed link
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
                <div class="relative z-10 flex items-center gap-4">
                    <!-- Icon Bubble -->
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl shadow-sm transition-transform group-hover:scale-110 group-hover:rotate-3"
                        :class="stat.iconBg"
                    >
                        <component :is="stat.icon" class="h-7 w-7" />
                    </div>

                    <!-- Text Content -->
                    <div>
                        <p
                            class="text-sm font-bold tracking-wider uppercase opacity-80"
                        >
                            {{ stat.label }}
                        </p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-3xl font-black">
                                {{ stat.value }}
                            </h3>
                        </div>
                        <p
                            class="mt-1 text-xs font-medium"
                            :class="stat.trendColor"
                        >
                            {{ stat.trend }}
                        </p>
                    </div>
                </div>

                <!-- Decorative Big Icon -->
                <component
                    :is="stat.icon"
                    class="absolute -right-6 -bottom-6 h-32 w-32 -rotate-12 transform opacity-10 transition-transform duration-500 group-hover:scale-110"
                />
            </div>
        </div>

        <!-- 2. Quick Actions (Static Menus) -->
        <div>
            <div class="mb-4 flex items-center justify-between">
                <h3
                    class="flex items-center gap-2 text-lg font-bold text-slate-800"
                >
                    <Activity class="h-5 w-5 text-[#99cc33]" />
                    Aksi Cepat
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                <Link
                    v-for="(action, index) in quickActions"
                    :key="index"
                    :href="action.href"
                    class="group relative flex flex-col items-center justify-center gap-3 overflow-hidden rounded-2xl p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                >
                    <!-- Background Gradient -->
                    <div
                        class="absolute inset-0 opacity-10 transition-opacity group-hover:opacity-20"
                        :class="action.bg"
                    ></div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full shadow-md transition-transform duration-300 group-hover:scale-110"
                        :class="action.bg + ' ' + action.color"
                    >
                        <component :is="action.icon" class="h-6 w-6" />
                    </div>
                    <span
                        class="z-10 text-center text-sm font-bold text-slate-700 group-hover:text-slate-900"
                    >
                        {{ action.label }}
                    </span>
                </Link>
            </div>
        </div>

        <!-- 3. Recent Activity (Dynamic Aggregation) -->
        <div>
            <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
                <!-- Header Card -->
                <div
                    class="flex items-center justify-between rounded-t-2xl border-b border-slate-100 bg-slate-50/50 p-5"
                >
                    <h3
                        class="flex items-center gap-2 font-bold text-slate-800"
                    >
                        <Clock class="h-5 w-5 text-slate-400" />
                        Aktivitas Terkini
                    </h3>
                    <!-- <button class="text-slate-400 hover:text-[#99cc33] transition-colors p-1 hover:bg-slate-100 rounded-full">
                        <MoreHorizontal class="w-5 h-5" />
                    </button> -->
                </div>

                <!-- List Content -->
                <div class="p-2">
                    <!-- Guard clause: gunakan length dari props.recentActivities yang sudah diduafultkan -->
                    <div
                        v-if="recentActivities && recentActivities.length > 0"
                        class="divide-y divide-slate-50"
                    >
                        <div
                            v-for="(activity, index) in recentActivities"
                            :key="index"
                            class="group flex items-center gap-4 rounded-xl p-4 transition-all hover:bg-slate-50"
                        >
                            <!-- Icon Indicator -->
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
                                :class="activity.bg_icon"
                            >
                                <component
                                    :is="
                                        iconMap[activity.icon_type] || Activity
                                    "
                                    class="h-5 w-5"
                                />
                            </div>

                            <!-- Content -->
                            <div class="min-w-0 flex-grow">
                                <div
                                    class="mb-0.5 flex items-start justify-between"
                                >
                                    <h4
                                        class="truncate pr-4 text-sm font-bold text-slate-700 transition-colors group-hover:text-[#99cc33]"
                                    >
                                        {{ activity.title }}
                                    </h4>
                                    <span
                                        class="text-xs whitespace-nowrap text-slate-400"
                                        >{{ timeAgo(activity.time_raw) }}</span
                                    >
                                </div>
                                <div
                                    class="flex items-center gap-2 text-xs text-slate-500"
                                >
                                    <span class="font-medium">{{
                                        activity.type
                                    }}</span>
                                    <span
                                        class="h-1 w-1 rounded-full bg-slate-300"
                                    ></span>
                                    <span
                                        class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold tracking-wide text-slate-500 uppercase"
                                    >
                                        {{ activity.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="flex flex-col items-center justify-center py-12 text-center text-slate-400"
                    >
                        <div class="mb-3 rounded-full bg-slate-50 p-4">
                            <Activity class="h-8 w-8 opacity-50" />
                        </div>
                        <p class="text-sm font-medium">
                            Belum ada aktivitas terbaru.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
