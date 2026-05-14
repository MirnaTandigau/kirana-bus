<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
            {{ __('Jelajahi Manado & Toraja') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12 bg-gray-50" x-data="{ modalOpen: false, activePlace: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900">Wonderful <span class="text-blue-600">Kirana Explore</span></h1>
                <p class="mt-2 md:mt-4 text-sm md:text-base lg:text-lg text-gray-600">Temukan keajaiban alam dan budaya di rute perjalanan kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8">
                @forelse($destinations as $place)
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 flex flex-col">
                    
                    <div class="relative h-48 md:h-56 bg-blue-600 flex items-center justify-center text-white overflow-hidden shrink-0">
                        @if($place->foto)
                            <img src="{{ asset('storage/' . $place->foto) }}" alt="{{ $place->judul }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1518107616385-ad508bc1dd6f?q=80&w=500" alt="Placeholder" class="absolute inset-0 w-full h-full object-cover opacity-60">
                        @endif

                        <div class="relative z-10 text-center px-4">
                            <span class="px-2 md:px-3 py-1 bg-black/30 backdrop-blur-md rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest text-white shadow-lg">
                                {{ $place->lokasi ?? 'Destinasi' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 md:p-6 flex flex-col flex-grow">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">{{ $place->judul }}</h3>
                        
                        <p class="text-gray-600 text-xs md:text-sm leading-relaxed mb-4 md:mb-6 line-clamp-3 flex-grow">
                            {{ $place->deskripsi }}
                        </p>
                        
                        <div class="flex items-center justify-between border-t pt-4 mt-auto">
                            <button @click="activePlace = {{ json_encode([
                                        'judul' => $place->judul,
                                        'lokasi' => $place->lokasi ?? 'Destinasi',
                                        'deskripsi' => $place->deskripsi,
                                        'foto' => $place->foto ? asset('storage/' . $place->foto) : 'https://images.unsplash.com/photo-1518107616385-ad508bc1dd6f?q=80&w=500'
                                    ]) }}; modalOpen = true" 
                                    class="inline-flex items-center text-blue-600 font-bold text-xs md:text-sm hover:text-blue-800 transition focus:outline-none">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right ml-2 text-[10px] md:text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-12 md:py-20">
                    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-dashed border-gray-300">
                        <p class="text-xs md:text-sm text-gray-400 italic">Belum ada destinasi wisata yang ditambahkan oleh admin.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
        </div>

        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            
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

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-2xl border border-slate-100">
                    
                    <button @click="modalOpen = false" class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-black/40 text-white hover:bg-red-500 transition focus:outline-none backdrop-blur-md">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <div class="relative h-48 sm:h-64 md:h-80 w-full bg-slate-200">
                        <img :src="activePlace ? activePlace.foto : ''" :alt="activePlace ? activePlace.judul : ''" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 left-4 md:left-6">
                            <span x-text="activePlace ? activePlace.lokasi : ''" class="px-3 py-1 md:px-4 md:py-1.5 bg-black/40 backdrop-blur-md rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest text-white shadow-lg border border-white/20"></span>
                        </div>
                    </div>

                    <div class="p-5 md:p-8 bg-white">
                        <h3 x-text="activePlace ? activePlace.judul : ''" class="text-xl md:text-2xl lg:text-3xl font-extrabold text-slate-900 mb-3 md:mb-4"></h3>
                        
                        <div class="w-12 md:w-16 h-1 md:h-1.5 bg-blue-600 rounded-full mb-4 md:mb-6"></div>

                        <p x-text="activePlace ? activePlace.deskripsi : ''" class="text-slate-600 text-sm md:text-base leading-relaxed whitespace-pre-line mb-6 md:mb-8"></p>
                        
                        <div class="bg-blue-50 -mx-5 md:-mx-8 -mb-5 md:-mb-8 p-5 md:p-8 mt-4 md:mt-6 border-t border-blue-100 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h4 class="font-bold text-slate-800 text-base md:text-lg mb-1">Tertarik mengunjungi tempat ini?</h4>
                                <p class="text-slate-500 text-xs md:text-sm mb-4 md:mb-0">Pesan tiket bus perjalanan Anda sekarang juga.</p>
                            </div>
                            <a href="{{ route('tickets.index') }}" class="inline-flex justify-center items-center px-4 py-2.5 md:px-6 md:py-3 rounded-xl bg-blue-600 text-white font-bold text-sm md:text-base hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 whitespace-nowrap w-full sm:w-auto">
                                <i class="fa-solid fa-ticket mr-2"></i> Pesan Tiket
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
</x-app-layout>