<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Tambah Antrian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('staff.queues.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Pasien</label>
                            <select name="patient_id" id="patient_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->nama }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="poli_id" class="block text-gray-700 text-sm font-bold mb-2">Poli</label>
                            <select name="poli_id" id="poli_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">-- Pilih Poli --</option>
                                <option value="1">Poli Penyakit Dalam</option>
                            </select>
                            @error('poli_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="dokter_id" class="block text-gray-700 text-sm font-bold mb-2">Dokter (Opsional)</label>
                            <select name="dokter_id" id="dokter_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Prioritas</label>
                            <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="ringan" {{ old('priority') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="sedang" {{ old('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="berat" {{ old('priority') == 'berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                            @error('priority')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="appointment_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Janji Temu (Opsional)</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('appointment_time') }}">
                            @error('appointment_time')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="checkup_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Periksa</label>
                            <input type="date" name="checkup_date" id="checkup_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('checkup_date', now()->toDateString()) }}" required>
                            @error('checkup_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="jenis_kunjungan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kunjungan</label>
                            <select name="jenis_kunjungan" id="jenis_kunjungan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="baru" {{ old('jenis_kunjungan') == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="lama" {{ old('jenis_kunjungan') == 'lama' ? 'selected' : '' }}>Lama</option>
                            </select>
                            @error('jenis_kunjungan')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="complaint" class="block text-gray-700 text-sm font-bold mb-2">Keluhan</label>
                            <textarea name="complaint" id="complaint" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('complaint') }}</textarea>
                            @error('complaint')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="is_emergency" class="block text-gray-700 text-sm font-bold mb-2">Darurat</label>
                            <input type="checkbox" name="is_emergency" id="is_emergency" class="form-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('is_emergency') ? 'checked' : '' }}>
                            @error('is_emergency')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                            <a href="{{ route('staff.queues.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
