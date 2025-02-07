<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nama Pasien:</strong>
                        <p>{{ $patient->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">NIK:</strong>
                        <p>{{ $patient->nik }}</p>
                     </div>
                   <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir:</strong>
                         <p>{{ $patient->tanggal_lahir->format('d-m-Y') }}</p>
                    </div>
                    <div class="mb-4">
                       <strong class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</strong>
                       <p>{{ $patient->jenis_kelamin }}</p>
                    </div>
                    <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Alamat:</strong>
                         <p>{{ $patient->alamat }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</strong>
                        <p>{{ $patient->no_telepon }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Riwayat Penyakit:</strong>
                        <p>{{ $patient->medical_history }}</p>
                    </div>
                   <div class="flex items-center justify-start">
                           <a href="{{ route('staff.patients.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                            </a>
                            <a href="{{ route('staff.patients.edit', $patient->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2 focus:outline-none focus:shadow-outline">
                                Edit
                            </a>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
