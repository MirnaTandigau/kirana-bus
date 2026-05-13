<x-app-layout>
    <x-slot name="header">
        Manajemen Jadwal Bus
    </x-slot>

    <div class="py-12 bg-gray-50" x-data="{ tab: '{{ request('tab', 'reguler') }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex flex-wrap items-center gap-2 w-full">
                
                <button @click="tab = 'reguler'" 
                        :class="tab === 'reguler' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-3 transition-all duration-300">
                    <i class="fa-regular fa-calendar-days text-lg"></i>
                    Jadwal Reguler
                </button>

                <button @click="tab = 'charter'" 
                        :class="tab === 'charter' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-3 transition-all duration-300">
                    <i class="fa-solid fa-van-shuttle text-lg"></i>
                    Jadwal Charter
                </button>

            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 min-h-[500px]">
                
                <div x-show="tab === 'reguler'" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4" 
                     x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <div class="border-b border-slate-100 pb-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg uppercase tracking-wider">Daftar Jadwal <span class="text-blue-600">Reguler</span></h3>
                            <p class="text-xs text-gray-500 mt-1">Jadwal bus penumpang dengan rute dan harga tiket tetap.</p>
                        </div>
                        <a href="{{ route('admin.schedules.create', ['type' => 'reguler']) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition">
                            <i class="fa-solid fa-plus"></i> Tambah Reguler
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">Informasi Bus</th>
                                    <th class="px-6 py-4">Jenis Jadwal</th>
                                    <th class="px-6 py-4">Rute Keberangkatan</th>
                                    <th class="px-6 py-4">Waktu & Tanggal</th>
                                    <th class="px-6 py-4 text-right">Harga Tiket</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($schedules->where('tipe_jadwal', 'reguler') as $schedule)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold mr-3">
                                                {{ substr($schedule->nama_bus, -1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">{{ $schedule->nama_bus }}</div>
                                                <div class="text-[10px] text-gray-400">Kapasitas: {{ $schedule->kapasitas }} Kursi</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md text-[10px] font-black uppercase border border-blue-100">Reguler</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-bold text-gray-600 uppercase">{{ $schedule->rute }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 font-medium">{{ $schedule->tanggal_berangkat->format('d M Y') }}</div>
                                        <div class="text-xs text-orange-600 font-bold">Jam {{ $schedule->jam_berangkat }} WITA</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-black text-green-700">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Edit Jadwal">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Ini dapat mempengaruhi data tiket terkait.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus Jadwal">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/50">
                                        Belum ada jadwal keberangkatan reguler yang ditambahkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="tab === 'charter'" style="display: none;"
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4" 
                     x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <div class="border-b border-slate-100 pb-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg uppercase tracking-wider">Daftar Jadwal <span class="text-indigo-600">Charter</span></h3>
                            <p class="text-xs text-gray-500 mt-1">Jadwal armada yang tersedia untuk disewa (harga ditentukan secara manual).</p>
                        </div>
                        <a href="{{ route('admin.schedules.create', ['type' => 'charter']) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold hover:bg-indigo-100 transition">
                            <i class="fa-solid fa-plus"></i> Tambah Charter
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-indigo-50 text-indigo-800 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">Informasi Bus</th>
                                    <th class="px-6 py-4">Jenis Jadwal</th>
                                    <th class="px-6 py-4">Wilayah Standby</th>
                                    <th class="px-6 py-4">Waktu & Tanggal</th>
                                    <th class="px-6 py-4 text-right">Harga Tiket</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($schedules->where('tipe_jadwal', 'charter') as $schedule)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3">
                                                {{ substr($schedule->nama_bus, -1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">{{ $schedule->nama_bus }}</div>
                                                <div class="text-[10px] text-gray-400">Kapasitas: {{ $schedule->kapasitas }} Kursi</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-md text-[10px] font-black uppercase border border-indigo-100">Charter</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-bold text-gray-600 uppercase">{{ $schedule->rute }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 font-medium">{{ $schedule->tanggal_berangkat->format('d M Y') }}</div>
                                        <div class="text-xs text-indigo-600 font-bold">Jam {{ $schedule->jam_berangkat }} WITA</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs font-bold text-gray-400 italic">Charter (Manual)</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Edit Jadwal">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal charter ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus Jadwal">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/50">
                                        Belum ada jadwal keberangkatan charter yang ditambahkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>