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

<!-- Modal untuk menampilkan keluhan lengkap -->
<div id="complaintModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Keluhan Pasien</h3>
                <button onclick="closeComplaintModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="bg-sky-50 rounded-lg p-4">
                <p id="complaintText" class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"></p>
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="closeComplaintModal()"
                        class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Function to show complaint modal
function showComplaintModal(complaint) {
    document.getElementById('complaintText').textContent = complaint;
    document.getElementById('complaintModal').classList.remove('hidden');
}

// Function to close complaint modal
function closeComplaintModal() {
    document.getElementById('complaintModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('complaintModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeComplaintModal();
    }
});

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterStatus = document.getElementById('filterStatus');
    const filterPriority = document.getElementById('filterPriority');
    const filterPoli = document.getElementById('filterPoli');
    const searchQueue = document.getElementById('searchQueue');
    const queueRows = document.querySelectorAll('.queue-row');

    function filterTable() {
        const statusFilter = filterStatus?.value.toLowerCase() || '';
        const priorityFilter = filterPriority?.value.toLowerCase() || '';
        const poliFilter = filterPoli?.value || '';
        const searchText = searchQueue?.value.toLowerCase() || '';

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
    }

    // Event listeners for filtering
    filterStatus?.addEventListener('change', filterTable);
    filterPriority?.addEventListener('change', filterTable);
    filterPoli?.addEventListener('change', filterTable);
    searchQueue?.addEventListener('input', filterTable);

    // Add row highlight for recently called queues
    queueRows.forEach(row => {
        const status = row.dataset.status;
        if (status === 'called') {
            row.classList.add('bg-yellow-50', 'border-l-4', 'border-yellow-400');
        }
        if (status === 'completed') {
            row.classList.add('bg-green-50', 'border-l-4', 'border-green-400');
        }
    });
});
</script>

<!-- Custom CSS for better styling -->
<style>
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

/* Smooth transitions */
.queue-row {
    transition: all 0.3s ease;
}

.queue-row:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Responsive design */
@media (max-width: 768px) {
    .queue-row td {
        padding: 0.75rem 0.5rem;
    }

    .queue-row .text-lg {
        font-size: 1rem;
    }

    .queue-row .flex-shrink-0 {
        display: none;
    }
}

/* Loading animation for status updates */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.status-updating {
    animation: pulse 1s ease-in-out infinite;
}
</style>
</x-app-layout>
