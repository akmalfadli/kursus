<!-- Floating WhatsApp Button -->
<a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $content['contact_phone']) }}?text=Halo%2C%20saya%20tertarik%20dengan%20kursus%20{{ urlencode($content['course_name']) }}.%0ANama%20%3A%20%0AAlamat%20%3A%20"
   target="_blank"
   rel="noopener noreferrer"
   class="fixed bottom-12 right-12 z-50 group"
   id="whatsapp-fab"
   aria-label="Chat via WhatsApp">
    <div class="relative">
        <!-- Main Button -->
        <div class="w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-2xl flex items-center justify-center transform transition-all duration-300 hover:scale-110 group-hover:shadow-green-500/50">
            <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </div>

        <!-- Pulse Animation -->
        <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>

        <!-- Tooltip -->
        <div class="absolute right-full mr-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            <div class="bg-slate-900 text-white px-4 py-2 rounded-lg shadow-xl whitespace-nowrap text-sm font-medium">
                Butuh Bantuan? Chat Kami!
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 rotate-45 w-2 h-2 bg-slate-900"></div>
            </div>
        </div>
    </div>
</a>

<!-- Notifications -->
@if($errors->any())
<div class="fixed top-4 right-4 bg-red-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm" id="error-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ $errors->first() }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm" id="success-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(100px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        60% {
            opacity: 0.95;
            transform: scale(1.02);
        }
    }

    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-slideUp {
        animation: slideUp 0.5s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* Responsive WhatsApp Button */
    @media (max-width: 640px) {
        #whatsapp-fab {
            bottom: 1rem;
            right: 1rem;
        }

        #whatsapp-fab .w-16 {
            width: 3.5rem;
            height: 3.5rem;
        }

        #whatsapp-fab svg {
            width: 2rem;
            height: 2rem;
        }
    }
</style>
