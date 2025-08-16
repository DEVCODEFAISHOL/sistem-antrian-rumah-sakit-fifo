<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Antrian Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Back Button -->
                    <div class="mb-4">
                        <a href="{{ route('staff.queues.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Daftar Antrian
                        </a>
                    </div>

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 border border-green-400 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Quota Alert -->
                    <div id="quota-alert" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                        <strong>Perhatian:</strong>
                        <span id="quota-message"></span>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('staff.queues.store') }}" method="POST" id="queue-form">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Pasien -->
                            <div class="mb-4">
                                <label for="patient_id" class="block text-sm font-medium text-gray-700">Pasien</label>
                                <select id="patient_id" name="patient_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Pasien</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->nama }} - {{ $patient->nik }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poli -->
                            <div class="mb-4">
                                <label for="poli_id" class="block text-sm font-medium text-gray-700">Poli</label>
                                <select id="poli_id" name="poli_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Poli</option>
                                    @foreach($polis as $poli)
                                        <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>
                                            {{ $poli->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('poli_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dokter -->
                            <div class="mb-4">
                                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter (Opsional)</label>
                                <select id="dokter_id" name="dokter_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tidak ada/Pilih dokter</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                            Dr. {{ $dokter->nama }} - {{ $dokter->spesialisasi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dokter_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Periksa -->
                            <div class="mb-4">
                                <label for="checkup_date" class="block text-sm font-medium text-gray-700">Tanggal Periksa</label>
                                <input type="date" id="checkup_date" name="checkup_date" required
                                    value="{{ old('checkup_date', date('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('checkup_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prioritas -->
                            <div class="mb-4">
                                <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                                <select id="priority" name="priority" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="ringan" {{ old('priority') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="sedang" {{ old('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="berat" {{ old('priority') == 'berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Janji (Opsional) -->
                            <div class="mb-4">
                                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Jam Janji (Opsional)</label>
                                <input type="time" id="appointment_time" name="appointment_time"
                                    value="{{ old('appointment_time') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('appointment_time')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kunjungan -->
                            <div class="mb-4">
                                <label for="jenis_kunjungan" class="block text-sm font-medium text-gray-700">Jenis Kunjungan</label>
                                <select id="jenis_kunjungan" name="jenis_kunjungan" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="baru" {{ old('jenis_kunjungan') == 'baru' ? 'selected' : '' }}>Pasien Baru</option>
                                    <option value="lama" {{ old('jenis_kunjungan') == 'lama' ? 'selected' : '' }}>Pasien Lama</option>
                                </select>
                                @error('jenis_kunjungan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-4">
                            <label for="complaint" class="block text-sm font-medium text-gray-700">Keluhan</label>
                            <textarea id="complaint" name="complaint" rows="3" placeholder="Masukkan keluhan pasien..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('complaint') }}</textarea>
                            @error('complaint')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan Tambahan</label>
                            <textarea id="keterangan" name="keterangan" rows="2" placeholder="Keterangan tambahan..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Emergency Checkbox -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input id="is_emergency" name="is_emergency" type="checkbox" value="1"
                                    {{ old('is_emergency') ? 'checked' : '' }}
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label for="is_emergency" class="ml-2 block text-sm text-gray-900">
                                    <span class="font-medium text-red-600">Kasus Darurat</span>
                                    <span class="text-gray-500"> - Antrian akan diprioritaskan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('staff.queues.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" id="submit-btn"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Tambah Antrian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const poliSelect = document.getElementById('poli_id');
            const dateInput = document.getElementById('checkup_date');
            const quotaAlert = document.getElementById('quota-alert');
            const quotaMessage = document.getElementById('quota-message');
            const submitBtn = document.getElementById('submit-btn');

            // Function to check quota
            function checkQuota() {
                const poliId = poliSelect.value;
                const date = dateInput.value;

                if (!poliId || !date) {
                    quotaAlert.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('staff.queues.get-poli-quota') }}?poli_id=${poliId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_full) {
                            quotaAlert.classList.remove('hidden');
                            quotaAlert.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
                            quotaMessage.textContent = `Kuota poli ini sudah penuh (${data.used}/${data.max_quota}). Silakan pilih tanggal lain.`;
                            submitBtn.disabled = true;
                            submitBtn.className = 'bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed';
                        } else {
                            if (data.available <= 5) {
                                quotaAlert.classList.remove('hidden');
                                quotaAlert.className = 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4';
                                quotaMessage.textContent = `Sisa kuota: ${data.available} dari ${data.max_quota} (${data.used} sudah terpakai)`;
                            } else {
                                quotaAlert.classList.add('hidden');
                            }

                            submitBtn.disabled = false;
                            submitBtn.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        quotaAlert.classList.add('hidden');
                    });
            }

            // Event listeners
            poliSelect.addEventListener('change', checkQuota);
            dateInput.addEventListener('change', checkQuota);

            // Check quota on page load if values exist
            if (poliSelect.value && dateInput.value) {
                checkQuota();
            }
        });
    </script>
    @endpush
</x-app-layout>
