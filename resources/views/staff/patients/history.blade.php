<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Antrian Pasien: ' . $patient->nama) }}
        </h2>
    </x-slot>

   <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                 @if(session('success'))
                    <div class="bg-green-200 text-green-800 border border-green-400 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                  @if(session('error'))
                <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                {{-- Remove redundant "Nama Pasien" column --}}
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Pesan</th>
                                 <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Panggil</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                       <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($queues as $queue)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    {{--  No need to display patient name again, it's in the header --}}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $queue->queue_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $queue->poli->nama ?? '-' }}</td>  {{-- Use null coalescing operator --}}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $queue->dokter ? $queue->dokter->nama : 'Tidak ada' }}</td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                         {{-- Format dates consistently --}}
                                         {{ $queue->created_at ? $queue->created_at->format('d-m-Y H:i:s') : '-' }}
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Format dates, and handle nulls --}}
                                        {{ $queue->called_time ? $queue->called_time->format('d-m-Y H:i:s') : '-' }}
                                     </td>
                                       <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                             @if($queue->status == 'waiting') bg-yellow-100 text-yellow-800
                                            @elseif($queue->status == 'called') bg-blue-100 text-blue-800
                                             @elseif($queue->status == 'skipped') bg-gray-100 text-gray-800
                                              @elseif($queue->status == 'completed') bg-green-100 text-green-800
                                             @endif">
                                                {{ $queue->status }}
                                            </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" colspan="7">Tidak ada riwayat antrian pasien.</td> {{-- Correct colspan --}}
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('staff.patients.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Kembali ke Daftar Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
