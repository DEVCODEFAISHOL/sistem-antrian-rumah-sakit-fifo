<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sky-800 leading-tight">
            {{ __('Dashboard Antrian') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-sky-50 to-sky-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Antrian Hari Ini -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-sky-100 text-sky-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                            <p class="text-3xl font-bold text-sky-700">{{ $totalQueuesToday }}</p>
                        </div>
                    </div>
                </div>

                <!-- Antrian Terpanggil -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Terpanggil</p>
                            <p class="text-3xl font-bold text-emerald-700">{{ $totalCalledQueues }}</p>
                        </div>
                    </div>
                </div>

                <!-- Antrian Menunggu -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menunggu</p>
                            <p class="text-3xl font-bold text-amber-700">{{ $totalQueuesToday - $totalCalledQueues }}</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Persentase -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Progress</p>
                            <p class="text-3xl font-bold text-purple-700">
                                {{ $totalQueuesToday > 0 ? round(($totalCalledQueues / $totalQueuesToday) * 100) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Queue Display -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Antrian Terakhir -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6">
                    <h3 class="text-lg font-semibold text-sky-800 mb-4">Antrian Terakhir</h3>
                    @if($lastQueue)
                        <div class="text-center p-6 bg-sky-50 rounded-lg">
                            <div class="text-4xl font-bold text-sky-700 mb-2">{{ $lastQueue->queue_number }}</div>
                            <div class="text-gray-600">{{ $lastQueue->patient->name ?? 'Pasien' }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $lastQueue->called_time }}</div>
                        </div>
                    @else
                        <div class="text-center p-6 text-gray-500">
                            Belum ada antrian yang dipanggil
                        </div>
                    @endif
                </div>

                <!-- Antrian Selanjutnya -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6">
                    <h3 class="text-lg font-semibold text-sky-800 mb-4">Antrian Selanjutnya</h3>
                    @if($nextQueue)
                        <div class="text-center p-6 bg-amber-50 rounded-lg">
                            <div class="text-4xl font-bold text-amber-700 mb-2">{{ $nextQueue->queue_number }}</div>
                            <div class="text-gray-600">{{ $nextQueue->patient->name ?? 'Pasien' }}</div>
                            <div class="text-sm text-gray-500 mt-1">Prioritas: {{ ucfirst($nextQueue->priority) }}</div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <form action="{{ route('admin.queues.call', $nextQueue->id) }}" method="POST" class="inline-block w-full">
                                @csrf
                                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                    Panggil Antrian
                                </button>
                            </form>
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.queues.skip', $nextQueue->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-1 px-3 rounded-lg text-sm transition-colors duration-200">
                                        Lewati
                                    </button>
                                </form>
                                <form action="{{ route('admin.queues.complete', $nextQueue->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-1 px-3 rounded-lg text-sm transition-colors duration-200">
                                        Selesai
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center p-6 text-gray-500">
                            Tidak ada antrian menunggu
                        </div>
                    @endif
                </div>

                <!-- Antrian Berdasarkan Prioritas -->
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6">
                    <h3 class="text-lg font-semibold text-sky-800 mb-4">Antrian Prioritas</h3>

                    <!-- Prioritas Berat -->
                    @if($currentQueueHeavy)
                        <div class="mb-4 p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-2xl font-bold text-red-700">{{ $currentQueueHeavy->queue_number }}</div>
                                    <div class="text-sm text-gray-600">{{ $currentQueueHeavy->patient->name ?? 'Pasien' }}</div>
                                    <div class="text-xs text-red-600 font-medium">BERAT</div>
                                </div>
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Prioritas Ringan-Sedang -->
                    @if($currentQueueLightMedium)
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-2xl font-bold text-yellow-700">{{ $currentQueueLightMedium->queue_number }}</div>
                                    <div class="text-sm text-gray-600">{{ $currentQueueLightMedium->patient->name ?? 'Pasien' }}</div>
                                    <div class="text-xs text-yellow-600 font-medium">{{ strtoupper($currentQueueLightMedium->priority) }}</div>
                                </div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            </div>
                        </div>
                    @endif

                    @if(!$currentQueueHeavy && !$currentQueueLightMedium)
                        <div class="text-center p-4 text-gray-500">
                            Tidak ada antrian berdasarkan prioritas
                        </div>
                    @endif
                </div>
            </div>

            <!-- Queue Table -->
            <div class="bg-white rounded-xl shadow-lg border border-sky-200 overflow-hidden">
                <div class="px-6 py-4 bg-sky-600">
                    <h3 class="text-lg font-semibold text-white">Daftar Antrian Hari Ini</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">No. Antrian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Waktu Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Waktu Panggil</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-sky-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($queues as $queue)
                                <tr class="hover:bg-sky-25 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-sky-700">{{ $queue->queue_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $queue->patient->name ?? 'Pasien' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($queue->priority == 'berat') bg-red-100 text-red-800
                                            @elseif($queue->priority == 'sedang') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($queue->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($queue->status == 'called') bg-emerald-100 text-emerald-800
                                            @elseif($queue->status == 'waiting') bg-amber-100 text-amber-800
                                            @elseif($queue->status == 'completed') bg-blue-100 text-blue-800
                                            @elseif($queue->status == 'skipped') bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($queue->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $queue->created_at->format('H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $queue->called_time ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($queue->status == 'waiting')
                                            <div class="flex space-x-2">
                                                <form action="{{ route('admin.queues.call', $queue->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-sky-600 hover:text-sky-800 font-medium">
                                                        Panggil
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.queues.skip', $queue->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-amber-600 hover:text-amber-800 font-medium">
                                                        Lewati
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.queues.complete', $queue->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-medium">
                                                        Selesai
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada antrian hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6">
                    <h3 class="text-lg font-semibold text-sky-800 mb-4">Laporan Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.reports.visits') }}" class="block w-full text-center bg-sky-100 hover:bg-sky-200 text-sky-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Laporan Kunjungan
                        </a>
                        <a href="{{ route('admin.reports.waiting-time') }}" class="block w-full text-center bg-sky-100 hover:bg-sky-200 text-sky-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Laporan Waktu Tunggu
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-sky-200 p-6">
                    <h3 class="text-lg font-semibold text-sky-800 mb-4">Ringkasan Hari Ini</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Pendaftar:</span>
                            <span class="font-semibold text-sky-700">{{ $totalQueuesToday }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sudah Dilayani:</span>
                            <span class="font-semibold text-emerald-600">{{ $totalCalledQueues }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Masih Menunggu:</span>
                            <span class="font-semibold text-amber-600">{{ $totalQueuesToday - $totalCalledQueues }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Efisiensi:</span>
                            <span class="font-semibold text-purple-600">
                                {{ $totalQueuesToday > 0 ? round(($totalCalledQueues / $totalQueuesToday) * 100) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
