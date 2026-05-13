<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.schedules.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $type == 'charter' ? __('Tambah Jadwal Charter (Unit Free)') : __('Tambah Jadwal Keberangkatan Reguler') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <x-input-label for="nama_bus" :value="__('Pilih Armada Bus')" />
                                <select name="nama_bus" id="nama_bus" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition" required>
                                    <option value="" disabled selected>Pilih Bus</option>
                                    <option value="Bus 1" {{ old('nama_bus') == 'Bus 1' ? 'selected' : '' }}>Bus 1</option>
                                    <option value="Bus 2" {{ old('nama_bus') == 'Bus 2' ? 'selected' : '' }}>Bus 2</option>
                                    <option value="Bus 3" {{ old('nama_bus') == 'Bus 2' ? 'selected' : '' }}>Bus 3</option>
                                </select>
                                <x-input-error :messages="$errors->get('nama_bus')" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="rute" :value="__('Rute Perjalanan')" />
                                <select name="rute" id="rute" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition" required>
                                    <option value="" disabled selected>Pilih Rute</option>
                                    <option value="Manado-Toraja" {{ old('rute') == 'Manado-Toraja' ? 'selected' : '' }}>Manado → Toraja</option>
                                    <option value="Toraja-Manado" {{ old('rute') == 'Toraja-Manado' ? 'selected' : '' }}>Toraja → Manado</option>
                                    @if($type == 'charter')
                                        <option value="" disabled selected>Pilih Wilayah Perjalanan</option>
                                        <option value="Area Sulut" {{ old('rute') == 'Custom / Fleksibel' ? 'selected' : '' }}>Area Sulut</option>
                                        <option value="Area Toraja" {{ old('rute') == 'Custom / Fleksibel' ? 'selected' : '' }}>Area Toraja</option>
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('rute')" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="tanggal_berangkat" :value="__('Tanggal Keberangkatan')" />
                                <x-text-input id="tanggal_berangkat" class="block mt-1 w-full rounded-xl" type="date" name="tanggal_berangkat" :value="old('tanggal_berangkat')" min="{{ date('Y-m-d') }}" required />
                                <x-input-error :messages="$errors->get('tanggal_berangkat')" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="jam_berangkat" :value="__('Jam Keberangkatan (WITA)')" />
                                <x-text-input id="jam_berangkat" class="block mt-1 w-full rounded-xl" type="time" name="jam_berangkat" :value="old('jam_berangkat')" required />
                                <x-input-error :messages="$errors->get('jam_berangkat')" class="mt-2" />
                            </div>

                            @if($type == 'reguler')
                            <div class="col-span-1">
                                <x-input-label for="harga" :value="__('Harga Tiket (Rp)')" />
                                <x-text-input id="harga" class="block mt-1 w-full rounded-xl" type="number" name="harga" :value="old('harga')" placeholder="Contoh: 350000" required />
                                <p class="mt-1 text-[10px] text-gray-400 font-medium">*Angka saja tanpa titik/koma</p>
                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                            </div>
                            @else
                            <div class="col-span-1">
                                <x-input-label :value="__('Status Harga')" />
                                <div class="mt-2 p-3 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-700 text-xs font-bold italic">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Harga akan diinput manual oleh admin saat user memesan unit ini.
                                </div>
                            </div>
                            @endif

                            <div class="col-span-1">
                                <x-input-label for="kapasitas" :value="__('Kapasitas Penumpang')" />
                                <x-text-input id="kapasitas" class="block mt-1 w-full rounded-xl" type="number" name="kapasitas" :value="old('kapasitas', 33)" required />
                                <x-input-error :messages="$errors->get('kapasitas')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                            <a href="{{ route('admin.schedules.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="{{ $type == 'charter' ? 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-200' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' }} px-6 py-2.5 text-white rounded-xl font-bold text-sm shadow-lg transition duration-150">
                                Simpan Jadwal {{ ucfirst($type) }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>