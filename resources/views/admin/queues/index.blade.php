<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Kelola Antrian') }}
            </h2>
            <a href="{{ route('admin.queues.create') }}"
                class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Tambah Antrian
            </a>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.
                            Antrian</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pasien</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dokter</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prioritas</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu
                            Janji</th>
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $queue->patient->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $queue->poli->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $queue->dokter ? $queue->dokter->nama : 'Tidak ada' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $queue->priority }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $queue->appointment_time ? $queue->appointment_time->format('H:i') : '-' }}</td>
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
                                <a href="{{ route('admin.queues.show', $queue->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                <a href="{{ route('admin.queues.edit', $queue->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900 ml-2">Edit</a>
                                {{-- <a href="{{ route('admin.queues.print', $queue->id) }}" class="text-blue-600 hover:text-blue-900 ml-2" target="_blank">Print</a> --}}
                                <form action="{{ route('admin.queues.destroy', $queue->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap" colspan="8">Tidak ada data antrian hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
