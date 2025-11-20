<script setup>
import { ref } from 'vue'
import { MessageCircle, X, Send } from 'lucide-vue-next'

const isOpen = ref(false)
const formData = ref({
    nama: '',
    email: '',
    pertanyaan: ''
})

const handleSubmit = (e) => {
    e.preventDefault()
    alert('Pertanyaan Anda telah berhasil dikirim! Tim pustakawan kami akan segera merespons.')
    formData.value = { nama: '', email: '', pertanyaan: '' }
    isOpen.value = false
}
</script>

<template>
    <div>
        <button v-if="!isOpen" @click="isOpen = true" 
            class="fixed z-50 flex items-center justify-center text-white rounded-full shadow-lg transition-all hover:scale-110 
            bg-gradient-to-br from-[var(--primary-green)] to-[var(--primary-green)] hover:from-[var(--primary-green)] hover:to-emerald-700
            
            /* Mobile (Default) */
            bottom-4 right-4 w-14 h-14 
            
            /* Desktop (sm ke atas) */
            sm:bottom-10 sm:right-10 sm:w-20 sm:h-20" 
            aria-label="Tanya Pustakawan">
            
            <MessageCircle class="w-6 h-6 sm:w-8 sm:h-8" />
            
            <svg viewBox="0 0 100 60"
                class="hidden sm:block absolute -top-6 left-1/2 -translate-x-1/2 w-50 pointer-events-none select-none">
                <path id="curve" d="M10,50 A40,40 0 0,1 90,50" fill="transparent" />
                <text font-size="8" fill="var(--primary-green)" font-weight="bold" text-anchor="middle">
                    <textPath href="#curve" startOffset="50%">
                        Tanya Pustakawan
                    </textPath>
                </text>
            </svg>
        </button>

        <transition name="fade">
            <div v-if="isOpen" 
                class="fixed z-50 bg-white overflow-hidden shadow-2xl border-gray-200
                
                /* Mobile: Menempel di bawah (Bottom Sheet), lebar penuh */
                bottom-0 left-0 right-0 w-full rounded-t-2xl border-t
                
                /* Desktop: Mengambang di kanan bawah */
                sm:bottom-32 sm:right-10 sm:left-auto sm:w-96 sm:rounded-2xl sm:border">
                
                <div class="bg-gradient-to-br from-[var(--primary-green)] to-[var(--primary-green)] text-white p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <MessageCircle class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Tanya Pustakawan</h3>
                            <p class="text-emerald-100 text-xs">Kami siap membantu Anda</p>
                        </div>
                    </div>
                    <button @click="isOpen = false"
                        class="text-white hover:bg-white/20 rounded-full p-1.5 transition-colors">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <form @submit="handleSubmit" class="p-4 space-y-4 max-h-[70vh] overflow-y-auto sm:max-h-none">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Lengkap
                            <input type="text" v-model="formData.nama" placeholder="Masukkan nama Anda" required
                            class="w-full mt-1 rounded-md border border-gray-300 p-2 focus:border-[var(--primary-green)] focus:ring focus:ring-emerald-200 transition outline-none" />
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email
                            <input type="email" v-model="formData.email" placeholder="email@example.com" required
                            class="w-full mt-1 rounded-md border border-gray-300 p-2 focus:border-[var(--primary-green)] focus:ring focus:ring-emerald-200 transition outline-none" />
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Pertanyaan Anda
                            <textarea v-model="formData.pertanyaan" placeholder="Tuliskan pertanyaan Anda di sini..."
                            required rows="4"
                            class="w-full mt-1 rounded-md border border-gray-300 p-2 focus:border-[var(--primary-green)] focus:ring focus:ring-emerald-200 resize-none transition outline-none"></textarea>
                        </label>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-[var(--primary-green)] to-[var(--primary-green)] 
                    hover:from-[var(--primary-green)] hover:to-emerald-700 text-white py-2.5 rounded-lg font-medium 
                    shadow-md transition-all hover:scale-[1.02]">
                        <Send class="w-4 h-4" />
                        Kirim Pertanyaan
                    </button>
                </form>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    /* Ubah animasi sedikit agar cocok untuk mobile (muncul dari bawah) */
    transform: translateY(20px);
}
</style>