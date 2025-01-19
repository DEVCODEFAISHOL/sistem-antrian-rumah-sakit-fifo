<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Poli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nama Poli:</strong>
                        <p>{{ $poli->nama }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Kode Poli:</strong>
                        <p>{{ $poli->kode_poli }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</strong>
                        <p>{{ $poli->deskripsi }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Lokasi:</strong>
                        <p>{{ $poli->lokasi }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Kapasitas Harian:</strong>
                        <p>{{ $poli->kapasitas_harian }}</p>
                    </div>
                       <div class="mb-4">
                            <strong class="block text-gray-700 text-sm font-bold mb-2">Dokter:</strong>
                            <p>{{ $poli->dokter ? $poli->dokter->nama : 'Tidak ada' }}</p>
                        </div>
                      <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Status:</strong>
                        <p> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $poli->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $poli->status }}
                                                </span></p>
                    </div>
                    <div class="flex items-center justify-start">
                           <a href="{{ route('admin.polis.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                            </a>
                           <a href="{{ route('admin.polis.edit', $poli->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2 focus:outline-none focus:shadow-outline">
                                Edit
                           </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
