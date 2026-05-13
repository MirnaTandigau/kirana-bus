<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Konten Wisata</h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-6 border-l-4 border-blue-600">
                <h3 class="font-bold text-lg mb-4">Tambah Destinasi Baru</h3>
                <form action="{{ route('admin.explore.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <div>
                        <x-input-label value="Judul Wisata" />
                        <x-text-input name="judul" type="text" class="block mt-1 w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Lokasi (Kabupaten/Kota)" />
                        <x-text-input name="lokasi" type="text" class="block mt-1 w-full" placeholder="Contoh: Toraja Utara" required />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label value="Deskripsi Singkat" />
                        <textarea name="deskripsi" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>
                    <div>
                        <x-input-label value="Foto Destinasi" />
                        <input type="file" name="foto" class="block mt-1 w-full text-xs text-gray-500" required accept="image/*" />
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="bg-blue-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-800 transition shadow-lg">Simpan Destinasi</button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($explores as $ex)
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                    <img src="{{ asset('storage/' . $ex->foto) }}" class="h-40 w-full object-cover">
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900">{{ $ex->judul }}</h4>
                        <p class="text-[10px] text-blue-600 font-bold italic mb-2">📍 {{ $ex->lokasi }}</p>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $ex->deskripsi }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>