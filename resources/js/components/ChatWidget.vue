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
        <!-- Tombol Chat -->
        <button v-if="!isOpen" @click="isOpen = true" class="fixed bottom-15 right-15 z-50 w-20 h-20 bg-gradient-to-br from-[var(--primary-green)] to-[var(--primary-green)] 
             hover:from-[var(--primary-green)] hover:to-emerald-700 text-white rounded-full shadow-lg 
             flex items-center justify-center transition-all hover:scale-110" aria-label="Tanya Pustakawan">
            <MessageCircle class="w-6 h-6" />
            <!-- Tambahkan teks melengkung -->
            <svg viewBox="0 0 100 60"
                class="absolute -top-6 left-1/2 -translate-x-1/2 w-50 pointer-events-none select-none">
                <path id="curve" d="M10,50 A40,40 0 0,1 90,50" fill="transparent" />
                <text font-size="8" fill="white" font-weight="bold" text-anchor="middle">
                    <textPath href="#curve" startOffset="50%">
                        Tanya Pustakawan
                    </textPath>
                </text>
            </svg>
        </button>

        <!-- Widget Chat -->
        <transition name="fade">
            <div v-if="isOpen" class="fixed bottom-15 right-15 z-50 w-90 max-w-[calc(100vw-2rem)] bg-white rounded-2xl 
               shadow-2xl border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div
                    class="bg-gradient-to-br from-[var(--primary-green)] to-[var(--primary-green)] text-white p-4 flex items-center justify-between">
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

                <!-- Form -->
                <form @submit="handleSubmit" class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" v-model="formData.nama" placeholder="Masukkan nama Anda" required
                            class="w-full rounded-md border border-gray-300 focus:border-[var(--primary-green)] focus:ring focus:ring-emerald-200 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" v-model="formData.email" placeholder="email@example.com" required
                            class="w-full rounded-md border border-gray-300 focus:border-[var(--primary-green)] focus:ring focus:ring-emerald-200 transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pertanyaan Anda</label>
                        <textarea v-model="formData.pertanyaan" placeholder="Tuliskan pertanyaan Anda di sini..."
                            required rows="4"
                            class="w-full rounded-md border border-gray-300 focus:border-[var(--primary--green)] focus:ring focus:ring-emerald-200 resize-none transition"></textarea>
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
/* Animasi fade in/out untuk widget */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
