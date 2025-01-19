<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Antrian Hari Ini') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('staff.queues.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Antrian
                        </a>
                        <a href="{{ route('staff.queues.history') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Riwayat Antrian
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 border border-green-400 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. Antrian</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pasien</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Poli</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dokter</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Janji</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($queues as $queue)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue->queue_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue->patient->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue->poli->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $queue->dokter ? $queue->dokter->nama : 'Tidak ada' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue->priority }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $queue->appointment_time ? $queue->appointment_time->format('H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($queue->status == 'waiting') bg-yellow-100 text-yellow-800
                                            @elseif($queue->status == 'called') bg-blue-100 text-blue-800
                                            @elseif($queue->status == 'skipped') bg-gray-100 text-gray-800
                                            @elseif($queue->status == 'completed') bg-green-100 text-green-800 @endif">
                                                {{ $queue->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('staff.queues.show', $queue->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <a href="{{ route('staff.queues.edit', $queue->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900 ml-2">Edit</a>

                                                <a href="{{ route('staff.queues.print', $queue->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900">Print</a>
                                                <a href="{{ route('staff.queues.preview', $queue->id) }}" class="text-green-600 hover:text-green-900">Review</a>
                                            <form action="{{ route('staff.queues.destroy', $queue->id) }}"
                                                method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap" colspan="8">Tidak ada data antrian
                                            hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
