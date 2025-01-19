<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Edit Antrian') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <form action="{{ route('admin.queues.update', $queue->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="patient_id" class="block text-sm font-medium text-gray-700">Pasien</label>
                <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">Pilih Pasien</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $queue->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="poli_id" class="block text-sm font-medium text-gray-700">Rumah Sakit</label>
                <select name="poli_id" id="poli_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">Pilih Rumah Sakit</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}" {{ $queue->poli_id == $poli->id ? 'selected' : '' }}>{{ $poli->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="ringan" {{ $queue->priority == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ $queue->priority == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ $queue->priority == 'berat' ? 'selected' : '' }}>Berat</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Jam Pesan</label>
                <input type="time" name="appointment_time" id="appointment_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $queue->appointment_time ? \Carbon\Carbon::parse($queue->appointment_time)->format('H:i') : '' }}">
            </div>
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $queue->keterangan }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
