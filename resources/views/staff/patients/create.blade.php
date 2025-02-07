<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Tambah Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('staff.pasien.store') }}" method="POST">
                        @csrf
                         <div class="mb-4">
                            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Pasien</label>
                            <input type="text" name="nama" id="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nama') }}" required>
                            @error('nama')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                         </div>
                         <div class="mb-4">
                            <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                            <input type="text" name="nik" id="nik" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nik') }}" required>
                            @error('nik')
                                 <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                       </div>
                         <div class="mb-4">
                            <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_lahir') }}" required>
                             @error('tanggal_lahir')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                             @enderror
                        </div>
                        <div class="mb-4">
                           <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                           <select name="jenis_kelamin" id="jenis_kelamin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                 <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                           </select>
                            @error('jenis_kelamin')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                         </div>
                         <div class="mb-4">
                           <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                           <textarea name="alamat" id="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('alamat') }}</textarea>
                           @error('alamat')
                               <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                         </div>
                         <div class="mb-4">
                            <label for="no_telepon" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon</label>
                             <input type="text" name="no_telepon" id="no_telepon" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('no_telepon') }}" required>
                            @error('no_telepon')
                                 <p class="text-red-500 text-xs italic">{{ $message }}</p>
                             @enderror
                         </div>
                         <div class="mb-4">
                            <label for="medical_history" class="block text-gray-700 text-sm font-bold mb-2">Riwayat Penyakit (Opsional)</label>
                            <textarea name="medical_history" id="medical_history" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('medical_history') }}</textarea>
                            @error('medical_history')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                           @enderror
                         </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                              <a href="{{ route('staff.pasien.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Batal
                            </a>
                       </div>
                    </form>
                 </div>
            </div>
         </div>
     </div>
</x-app-layout>
