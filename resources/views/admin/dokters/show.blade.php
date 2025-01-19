<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nama Dokter:</strong>
                        <p>{{ $dokter->nama }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Spesialisasi:</strong>
                        <p>{{ $dokter->spesialisasi }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Email:</strong>
                        <p>{{ $dokter->email }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Telepon:</strong>
                        <p>{{ $dokter->telepon }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Alamat:</strong>
                        <p>{{ $dokter->alamat }}</p>
                    </div>
                      <div class="flex items-center justify-start">
                          <a href="{{ route('admin.dokters.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                            </a>
                           <a href="{{ route('admin.dokters.edit', $dokter->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2 focus:outline-none focus:shadow-outline">
                                Edit
                           </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
