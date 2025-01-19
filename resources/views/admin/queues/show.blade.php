<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Antrian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nomor Antrian</label>
                        <p class="mt-1">{{ $queue->queue_number }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pasien</label>
                        <p class="mt-1">{{ $queue->patient->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Poli </label>
                        <p class="mt-1">{{ $queue->poli->nama}}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                        <p class="mt-1">{{ ucfirst($queue->priority) }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jam Pesan</label>
                        <p class="mt-1">{{ $queue->appointment_time ? \Carbon\Carbon::parse($queue->appointment_time)->format('H:i') : '-' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <p class="mt-1">{{ $queue->keterangan ?? '-' }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">{{ ucfirst($queue->status) }}</p>
                    </div>
                    <a href="{{ route('admin.queues.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
