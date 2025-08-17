{{-- resources/views/staff/patients/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('staff.patients.index') }}"
               class="text-sky-600 hover:text-sky-800 transition duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pasien Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('staff.patients.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('nama') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap pasien">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nik"
                                   name="nik"
                                   value="{{ old('nik') }}"
                                   maxlength="16"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('nik') border-red-500 @enderror"
                                   placeholder="Masukkan NIK 16 digit">
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Row untuk Tanggal Lahir dan Jenis Kelamin --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date"
                                       id="tanggal_lahir"
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir') }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_kelamin"
                                        name="jenis_kelamin"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('jenis_kelamin') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat"
                                      name="alamat"
                                      rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('alamat') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap pasien">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel"
                                   id="no_telepon"
                                   name="no_telepon"
                                   value="{{ old('no_telepon') }}"
                                   maxlength="15"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('no_telepon') border-red-500 @enderror"
                                   placeholder="Contoh: 081234567890">
                            @error('no_telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Medical History --}}
                        <div>
                            <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">
                                Riwayat Medis
                            </label>
                            <textarea id="medical_history"
                                      name="medical_history"
                                      rows="4"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('medical_history') border-red-500 @enderror"
                                      placeholder="Masukkan riwayat medis pasien (opsional)">{{ old('medical_history') }}</textarea>
                            @error('medical_history')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('staff.patients.index') }}"
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="bg-sky-600 hover:bg-sky-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Pasien
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk validasi NIK --}}
    <script>
        document.getElementById('nik').addEventListener('input', function(e) {
            // Hanya izinkan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Batasi hingga 16 karakter
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });

        document.getElementById('no_telepon').addEventListener('input', function(e) {
            // Hanya izinkan angka dan tanda +
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    </script>
</x-app-layout>
