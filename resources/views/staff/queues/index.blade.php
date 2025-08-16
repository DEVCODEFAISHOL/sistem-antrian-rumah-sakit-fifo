<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Antrian') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('staff.queues.create') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Antrian
                </a>
                <a href="{{ route('staff.queues.history') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-sky-50 to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Antrian -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-sky-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-sky-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Menunggu -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['waiting'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dipanggil -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-yellow-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Dipanggil</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['called'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-green-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dilewati -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Dilewati</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['skipped'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kuota Poli Hari Ini -->
            @if($poliQuotas->count() > 0)
            <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                        </svg>
                        Kuota Poli Hari Ini ({{ now()->format('d/m/Y') }})
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($poliQuotas as $quota)
                        <div class="border rounded-lg p-4 {{ $quota->current_count >= $quota->max_quota ? 'border-red-300 bg-red-50' : 'border-green-300 bg-green-50' }}">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold text-gray-800">{{ $quota->poli->nama }}</h4>
                                <span class="text-xs {{ $quota->current_count >= $quota->max_quota ? 'text-red-600 bg-red-100' : 'text-green-600 bg-green-100' }} px-2 py-1 rounded-full">
                                    {{ $quota->current_count }}/{{ $quota->max_quota }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $quota->current_count >= $quota->max_quota ? 'bg-red-500' : 'bg-green-500' }}"
                                     style="width: {{ ($quota->current_count / $quota->max_quota) * 100 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                Sisa: {{ $quota->max_quota - $quota->current_count }} slot
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Filter dan Search -->
            <div class="bg-white rounded-xl shadow-lg mb-8 p-6">
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-4">
                        <!-- Filter Status -->
                        <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Semua Status</option>
                            <option value="waiting">Menunggu</option>
                            <option value="called">Dipanggil</option>
                            <option value="completed">Selesai</option>
                            <option value="skipped">Dilewati</option>
                        </select>

                        <!-- Filter Prioritas -->
                        <select id="filterPriority" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Semua Prioritas</option>
                            <option value="ringan">Ringan</option>
                            <option value="sedang">Sedang</option>
                            <option value="berat">Berat</option>
                        </select>

                        <!-- Filter Poli -->
                        <select id="filterPoli" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Semua Poli</option>
                            @foreach($queues->pluck('poli')->unique('id') as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="searchQueue" placeholder="Cari nomor antrian atau nama pasien..."
                               class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 w-64">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Daftar Antrian -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Daftar Antrian Hari Ini
                        <span class="ml-2 bg-white/20 px-3 py-1 rounded-full text-sm">{{ $queues->count() }}</span>
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    @if($queues->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200" id="queueTable">
                        <thead class="bg-sky-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                                    <div class="text-sm font-medium text-gray-900">{{ $queue->patient->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $queue->jenis_kunjungan == 'baru' ? 'Pasien Baru' : 'Pasien Lama' }}</div>
                                </td>

                                <!-- Poli -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $queue->poli->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $queue->poli->kode_poli }}</div>
                                </td>

                                <!-- Dokter -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $queue->dokter->nama ?? 'Belum ditentukan' }}
                                    </div>
                                </td>

                                <!-- Prioritas -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $priorityColors = [
                                            'ringan' => 'bg-green-100 text-green-800',
                                            'sedang' => 'bg-yellow-100 text-yellow-800',
                                            'berat' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColors[$queue->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($queue->priority) }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'waiting' => 'bg-blue-100 text-blue-800',
                                            'called' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'skipped' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusLabels = [
                                            'waiting' => 'Menunggu',
                                            'called' => 'Dipanggil',
                                            'completed' => 'Selesai',
                                            'skipped' => 'Dilewati'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$queue->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$queue->status] ?? ucfirst($queue->status) }}
                                    </span>
                                </td>

                                <!-- Keluhan -->
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="text-sm text-gray-900 truncate" title="{{ $queue->complaint }}">
                                        {{ $queue->complaint ?? 'Tidak ada keluhan' }}
                                    </div>
                                </td>

                                <!-- Waktu -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Daftar: {{ $queue->created_at->format('H:i') }}</div>
                                    @if($queue->called_time)
                                        <div>Panggil: {{ \Carbon\Carbon::parse($queue->called_time)->format('H:i') }}</div>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">

                                        @if($queue->status == 'waiting')
                                            <!-- Panggil -->
                                            <form action="{{ route('staff.queues.call', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Panggil antrian {{ $queue->queue_number }}?')"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                    </svg>
                                                    Panggil
                                                </button>
                                            </form>

                                            <!-- Lewati -->
                                            <form action="{{ route('staff.queues.skip', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Lewati antrian {{ $queue->queue_number }}?')"
                                                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Lewati
                                                </button>
                                            </form>
                                        @endif

                                        @if($queue->status == 'called')
                                            <!-- Selesai -->
                                            <form action="{{ route('staff.queues.complete', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Tandai antrian {{ $queue->queue_number }} selesai?')"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Selesai
                                                </button>
                                            </form>

                                            <!-- Panggil Ulang -->
                                            <form action="{{ route('staff.queues.call', $queue) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Ulang
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Detail -->
                                        <a href="{{ route('staff.queues.show', $queue) }}"
                                           class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('staff.queues.edit', $queue) }}"
                                           class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Print -->
                                        <a href="{{ route('staff.queues.print', $queue) }}"
                                           target="_blank"
                                           class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print
                                        </a>

                                        <!-- Delete (hanya untuk status completed atau skipped) -->
                                        @if(in_array($queue->status, ['completed', 'skipped']))
                                        <form action="{{ route('staff.queues.destroy', $queue) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Hapus antrian {{ $queue->queue_number }}? Tindakan ini tidak dapat dibatalkan!')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada antrian</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada pasien yang mendaftar antrian hari ini.</p>
                        <div class="mt-6">
                            <a href="{{ route('staff.queues.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Antrian Pertama
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript for filtering and searching -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterStatus = document.getElementById('filterStatus');
            const filterPriority = document.getElementById('filterPriority');
            const filterPoli = document.getElementById('filterPoli');
            const searchQueue = document.getElementById('searchQueue');
            const queueRows = document.querySelectorAll('.queue-row');

            function filterTable() {
                const statusFilter = filterStatus.value.toLowerCase();
                const priorityFilter = filterPriority.value.toLowerCase();
                const poliFilter = filterPoli.value;
                const searchText = searchQueue.value.toLowerCase();

                queueRows.forEach(row => {
                    const status = row.dataset.status.toLowerCase();
                    const priority = row.dataset.priority.toLowerCase();
                    const poli = row.dataset.poli;
                    const searchData = row.dataset.search;

                    const statusMatch = !statusFilter || status === statusFilter;
                    const priorityMatch = !priorityFilter || priority === priorityFilter;
                    const poliMatch = !poliFilter || poli === poliFilter;
                    const searchMatch = !searchText || searchData.includes(searchText);

                    if (statusMatch && priorityMatch && poliMatch && searchMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateEmptyState();
            }

            function updateEmptyState() {
                const visibleRows = document.querySelectorAll('.queue-row:not([style*="display: none"])').length;
                const tableContainer = document.querySelector('#queueTable').closest('.overflow-x-auto');
                const emptyState = document.querySelector('.text-center.py-12');

                if (visibleRows === 0 && queueRows.length > 0) {
                    // Hide table, show "no results" message
                    tableContainer.innerHTML = `
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada antrian yang sesuai dengan filter yang dipilih.</p>
                        </div>
                    `;
                } else if (visibleRows > 0) {
                    // Restore table if it was hidden
                    if (!tableContainer.querySelector('table')) {
                        location.reload(); // Simple solution: reload page to restore table
                    }
                }
            }

            // Event listeners
            filterStatus.addEventListener('change', filterTable);
            filterPriority.addEventListener('change', filterTable);
            filterPoli.addEventListener('change', filterTable);
            searchQueue.addEventListener('input', filterTable);

            // Auto refresh every 30 seconds
            setTimeout(function() {
                location.reload();
            }, 30000);

            // Sound notification for new calls (optional)
            const playCallSound = () => {
                // You can add audio notification here
                console.log('New queue called');
            };

            // Add row highlight for recently called queues
            queueRows.forEach(row => {
                const status = row.dataset.status;
                if (status === 'called') {
                    row.classList.add('bg-yellow-50', 'border-l-4', 'border-yellow-400');
                }
            });
        });

        // Helper function to confirm actions
        function confirmAction(action, queueNumber) {
            return confirm(`${action} antrian ${queueNumber}?`);
        }

        // Print function
        function printQueue(queueId) {
            const printWindow = window.open(`/staff/queues/${queueId}/print`, '_blank');
            printWindow.onload = function() {
                printWindow.print();
            };
        }
    </script>

    <!-- Custom CSS for better styling -->
    <style>
        @media (max-width: 768px) {
            .queue-row td {
                padding: 0.5rem;
                font-size: 0.875rem;
            }

            .queue-row .flex {
                flex-wrap: wrap;
                gap: 0.25rem;
            }

            .queue-row .flex .bg-green-500,
            .queue-row .flex .bg-orange-500,
            .queue-row .flex .bg-blue-500,
            .queue-row .flex .bg-yellow-500,
            .queue-row .flex .bg-sky-500,
            .queue-row .flex .bg-purple-500,
            .queue-row .flex .bg-gray-500,
            .queue-row .flex .bg-red-500 {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Smooth transitions */
        .queue-row {
            transition: all 0.3s ease;
        }

        .queue-row:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Priority indicators */
        .queue-row[data-priority="berat"] {
            border-left: 3px solid #ef4444;
        }

        .queue-row[data-priority="sedang"] {
            border-left: 3px solid #f59e0b;
        }

        .queue-row[data-priority="ringan"] {
            border-left: 3px solid #10b981;
        }

        /* Loading state for buttons */
        .queue-row button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</x-app-layout>
