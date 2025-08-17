<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Kelola Antrian') }}
            </h2>
            <div class="flex items-center space-x-4">
                <div class="bg-sky-100 text-sky-800 px-3 py-1 rounded-full text-sm">
                    Total Antrian: {{ $queues->count() }}/20
                </div>
                @if($queues->count() < 20)
                    <a href="{{ route('admin.queues.create') }}"
                        class="px-4 py-2 text-white bg-sky-500 rounded-md hover:bg-sky-600">
                        Tambah Antrian
                    </a>
                @else
                    <button disabled
                        class="px-4 py-2 text-white bg-gray-400 rounded-md cursor-not-allowed">
                        Kuota Penuh (20/20)
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-sky-50">
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
                    @foreach($queues as $queue)
                <tr class="hover:bg-gray-50 transition-colors duration-150 queue-row"
                    data-status="{{ $queue->status }}"
                    data-priority="{{ $queue->priority }}"
                    data-poli="{{ $queue->poli_id }}"
                    data-search="{{ strtolower($queue->queue_number . ' ' . $queue->patient->nama) }}">

                    <!-- No. Antrian -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-lg font-bold text-sky-600">{{ $queue->queue_number }}</span>
                            @if($queue->is_emergency)
                                <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Darurat</span>
                            @endif
                        </div>
                    </td>

                    <!-- Pasien -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $queue->patient->nama }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $queue->patient->nik }} •
                                    {{ $queue->jenis_kunjungan == 'baru' ? 'Pasien Baru' : 'Pasien Lama' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Poli -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $queue->poli->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $queue->poli->kode_poli ?? 'Kode tidak tersedia' }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- Dokter with Better Relation Handling -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($queue->dokter)
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">
                                        Dr. {{ $queue->dokter->nama }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $queue->dokter->spesialisasi ?? 'Umum' }}
                                    </div>
                                    @if($queue->dokter->status == 'tidak_aktif')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Tidak Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-500">Belum ditentukan</div>
                                        <div class="text-xs text-gray-400">Menunggu penugasan</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Prioritas -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $priorityConfig = [
                                'ringan' => [
                                    'bg' => 'bg-green-100 text-green-800',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                ],
                                'sedang' => [
                                    'bg' => 'bg-yellow-100 text-yellow-800',
                                    'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.232 16.5c-.77.833.192 2.5 1.732 2.5z'
                                ],
                                'berat' => [
                                    'bg' => 'bg-red-100 text-red-800',
                                    'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.232 16.5c-.77.833.192 2.5 1.732 2.5z'
                                ]
                            ];
                            $config = $priorityConfig[$queue->priority] ?? $priorityConfig['ringan'];
                        @endphp

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                            </svg>
                            {{ ucfirst($queue->priority) }}
                        </span>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusConfig = [
                                'waiting' => [
                                    'bg' => 'bg-blue-100 text-blue-800',
                                    'label' => 'Menunggu',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                ],
                                'called' => [
                                    'bg' => 'bg-yellow-100 text-yellow-800',
                                    'label' => 'Dipanggil',
                                    'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'
                                ],
                                'completed' => [
                                    'bg' => 'bg-green-100 text-green-800',
                                    'label' => 'Selesai',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                ],
                                'skipped' => [
                                    'bg' => 'bg-red-100 text-red-800',
                                    'label' => 'Dilewati',
                                    'icon' => 'M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z'
                                ]
                            ];
                            $statusConf = $statusConfig[$queue->status] ?? $statusConfig['waiting'];
                        @endphp

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConf['bg'] }}">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusConf['icon'] }}"/>
                            </svg>
                            {{ $statusConf['label'] }}
                        </span>
                    </td>

                    <!-- Keluhan -->
                    <td class="px-6 py-4">
                        <div class="max-w-xs">
                            @if($queue->complaint)
                                <div class="text-sm text-gray-900 break-words">
                                    {{ Str::limit($queue->complaint, 50) }}
                                </div>
                                @if(strlen($queue->complaint) > 50)
                                    <button onclick="showComplaintModal('{{ addslashes($queue->complaint) }}')"
                                            class="text-xs text-sky-600 hover:text-sky-800 mt-1">
                                        Lihat selengkapnya...
                                    </button>
                                @endif
                            @else
                                <span class="text-sm text-gray-400 italic">Tidak ada keluhan</span>
                            @endif
                        </div>
                    </td>

                    <!-- Waktu -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="space-y-1">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>{{ $queue->created_at->format('H:i') }}</span>
                            </div>

                            @if($queue->called_time)
                                <div class="flex items-center text-yellow-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($queue->called_time)->format('H:i') }}</span>
                                </div>
                            @endif

                            @if($queue->completed_time)
                                <div class="flex items-center text-green-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($queue->completed_time)->format('H:i') }}</span>
                                </div>
                            @endif

                            <div class="text-xs text-gray-400">
                                {{ $queue->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
