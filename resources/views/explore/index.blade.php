<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jelajahi Manado & Toraja') }}
        </h2>
    </x-slot>

    <!-- PENTING: Tambahkan x-data="{ modalOpen: false, activePlace: null }" di kontainer utama -->
    <div class="py-12 bg-gray-50" x-data="{ modalOpen: false, activePlace: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900">Wonderful <span class="text-blue-600">Kirana Explore</span></h1>
                <p class="mt-4 text-lg text-gray-600">Temukan keajaiban alam dan budaya di rute perjalanan kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($destinations as $place)
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 flex flex-col">
                    
                    <!-- Bagian Gambar -->
                    <div class="relative h-56 bg-blue-600 flex items-center justify-center text-white overflow-hidden shrink-0">
                        @if($place->foto)
                            <img src="{{ asset('storage/' . $place->foto) }}" alt="{{ $place->judul }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1518107616385-ad508bc1dd6f?q=80&w=500" alt="Placeholder" class="absolute inset-0 w-full h-full object-cover opacity-60">
                        @endif

                        <div class="relative z-10 text-center px-4">
                            <span class="px-3 py-1 bg-black/30 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-widest text-white shadow-lg">
                                {{ $place->lokasi ?? 'Destinasi' }}
                            </span>
                        </div>
                    </div>

                    <!-- Bagian Konten Teks -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $place->judul }}</h3>
                        
                        <!-- Deskripsi Pendek (Dibatasi 3 Baris) -->
                        <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
                            {{ $place->deskripsi }}
                        </p>
                        
                        <!-- Tombol Baca Selengkapnya -->
                        <div class="flex items-center justify-between border-t pt-4 mt-auto">
                            <!-- Mengirim data JSON dari PHP ke JavaScript Alpine -->
                            <button @click="activePlace = {{ json_encode([
                                        'judul' => $place->judul,
                                        'lokasi' => $place->lokasi ?? 'Destinasi',
                                        'deskripsi' => $place->deskripsi,
                                        'foto' => $place->foto ? asset('storage/' . $place->foto) : 'https://images.unsplash.com/photo-1518107616385-ad508bc1dd6f?q=80&w=500'
                                    ]) }}; modalOpen = true" 
                                    class="inline-flex items-center text-blue-600 font-bold text-sm hover:text-blue-800 transition focus:outline-none">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                @empty
                <!-- Pesan Kosong -->
                <div class="col-span-1 md:col-span-3 text-center py-20">
                    <div class="bg-white p-10 rounded-3xl shadow-sm border border-dashed border-gray-300">
                        <p class="text-gray-400 italic">Belum ada destinasi wisata yang ditambahkan oleh admin.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
        </div>

        <!-- ========================================== -->
        <!-- MODAL / POP-UP CARD MENGAMBANG -->
        <!-- ========================================== -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            
            <!-- Background Overlay Gelap (Klik untuk menutup) -->
            <div x-show="modalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="modalOpen = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity">
            </div>

            <!-- Kontainer Modal di Tengah -->
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-100">
                    
                    <!-- Tombol Silang (Close) -->
                    <button @click="modalOpen = false" class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-black/40 text-white hover:bg-red-500 transition focus:outline-none backdrop-blur-md">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Header Modal (Gambar Penuh) -->
                    <div class="relative h-64 sm:h-80 w-full bg-slate-200">
                        <img :src="activePlace ? activePlace.foto : ''" :alt="activePlace ? activePlace.judul : ''" class="w-full h-full object-cover">
                        <!-- Label Lokasi di Atas Gambar -->
                        <div class="absolute bottom-4 left-6">
                            <span x-text="activePlace ? activePlace.lokasi : ''" class="px-4 py-1.5 bg-black/40 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-widest text-white shadow-lg border border-white/20"></span>
                        </div>
                    </div>

                    <!-- Body Modal (Isi Teks) -->
                    <div class="p-6 sm:p-8 bg-white">
                        <h3 x-text="activePlace ? activePlace.judul : ''" class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-4"></h3>
                        
                        <!-- Divider Line -->
                        <div class="w-16 h-1.5 bg-blue-600 rounded-full mb-6"></div>

                        <!-- Deskripsi Penuh (Tidak Dibatasi Barisnya) -->
                        <p x-text="activePlace ? activePlace.deskripsi : ''" class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line mb-8"></p>
                        
                        <!-- Tombol CTA Pesan Tiket di Bawah Modal -->
                        <div class="bg-blue-50 -mx-6 sm:-mx-8 -mb-6 sm:-mb-8 p-6 sm:p-8 mt-4 border-t border-blue-100 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg mb-1">Tertarik mengunjungi tempat ini?</h4>
                                <p class="text-slate-500 text-sm mb-4 sm:mb-0">Pesan tiket bus perjalanan Anda sekarang juga.</p>
                            </div>
                            <a href="{{ route('tickets.index') }}" class="inline-flex justify-center items-center px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 whitespace-nowrap">
                                <i class="fa-solid fa-ticket mr-2"></i> Pesan Tiket
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ========================================== -->
        
    </div>
</x-app-layout>