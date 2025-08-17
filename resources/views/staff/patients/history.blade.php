{{-- resources/views/staff/patients/history.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('staff.patients.show', $patient) }}"
                   class="text-sky-600 hover:text-sky-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Riwayat Kunjungan') }}
                    </h2>
                    <p class="text-sm text-gray-600">{{ $patient->nama }} - {{ $patient->nik }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="bg-sky-100 text-sky-800 text-sm font-medium px-3 py-1 rounded-full">
                    Total: {{ $queues->count() }} kunjungan
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Patient Summary Card --}}
            <div class="bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg shadow-lg mb-6 overflow-hidden">
                <div class="px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $patient->nama }}</h3>
                                <p class="text-sky-100">{{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} tahun • {{ $patient->jenis_kelamin }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white text-sm opacity-90">NIK</div>
                            <div class="text-white font-mono text-lg">{{ $patient->nik }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History Timeline --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($queues->count() > 0)
                    <div class="p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($queues as $index => $queue)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                {{-- Status Icon --}}
                                                <div>
                                                    @php
                                                        $statusConfig = [
                                                            'menunggu' => ['bg' => 'bg-yellow-500', 'icon' => 'clock'],
                                                            'sedang_diperiksa' => ['bg' => 'bg-blue-500', 'icon' => 'user-check'],
                                                            'selesai' => ['bg' => 'bg-green-500', 'icon' => 'check'],
                                                            'dibatalkan' => ['bg' => 'bg-red-500', 'icon' => 'x']
                                                        ];
                                                        $config = $statusConfig[$queue->status] ?? $statusConfig['menunggu'];
                                                    @endphp

                                                    <span class="h-8 w-8 rounded-full {{ $config['bg'] }} flex items-center justify-center ring-8 ring-white">
                                                        @if($config['icon'] == 'clock')
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @elseif($config['icon'] == 'user-check')
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @elseif($config['icon'] == 'check')
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        @endif
                                                    </span>
                                                </div>

                                                {{-- Content --}}
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition duration-200">
                                                        <div class="flex items-start justify-between">
                                                            <div class="flex-1">
                                                                <div class="flex items-center space-x-2 mb-2">
                                                                    <h4 class="text-sm font-medium text-gray-900">
                                                                        Kunjungan ke {{ $queue->poli->nama ?? 'Poli tidak diketahui' }}
                                                                    </h4>
                                                                    @php
                                                                        $statusColors = [
                                                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                                            'sedang_diperiksa' => 'bg-blue-100 text-blue-800',
                                                                            'selesai' => 'bg-green-100 text-green-800',
                                                                            'dibatalkan' => 'bg-red-100 text-red-800'
                                                                        ];
                                                                    @endphp
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$queue->status] ?? $statusColors['menunggu'] }}">
                                                                        {{ ucfirst(str_replace('_', ' ', $queue->status)) }}
                                                                    </span>
                                                                </div>

                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                                                    <div class="flex items-center space-x-2">
                                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                        </svg>
                                                                        <span>Dr. {{ $queue->dokter->nama ?? 'Dokter tidak diketahui' }}</span>
                                                                    </div>

                                                                    <div class="flex items-center space-x-2">
                                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v1H6V9a2 2 0 012-2h3z"/>
                                                                        </svg>
                                                                        <span>No. Antrian: {{ $queue->nomor_antrian }}</span>
                                                                    </div>

                                                                    <div class="flex items-center space-x-2">
                                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        <span>{{ $queue->created_at->format('H:i') }}</span>
                                                                    </div>
                                                                </div>

                                                                {{-- Additional Info --}}
                                                                @if($queue->keluhan)
                                                                    <div class="mt-3 p-3 bg-sky-50 rounded-md border border-sky-200">
                                                                        <div class="flex items-start space-x-2">
                                                                            <svg class="w-4 h-4 text-sky-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                            </svg>
                                                                            <div>
                                                                                <p class="text-sm font-medium text-sky-700">Keluhan:</p>
                                                                                <p class="text-sm text-sky-600">{{ $queue->keluhan }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                {{-- Diagnosis & Treatment (jika ada) --}}
                                                                @if(isset($queue->diagnosis) && $queue->diagnosis)
                                                                    <div class="mt-3 p-3 bg-green-50 rounded-md border border-green-200">
                                                                        <div class="flex items-start space-x-2">
                                                                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                            </svg>
                                                                            <div>
                                                                                <p class="text-sm font-medium text-green-700">Diagnosis:</p>
                                                                                <p class="text-sm text-green-600">{{ $queue->diagnosis }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            {{-- Date --}}
                                                            <div class="text-right text-sm text-gray-500">
                                                                <p class="font-medium">{{ $queue->created_at->format('d M Y') }}</p>
                                                                <p class="text-xs">{{ $queue->created_at->diffForHumans() }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat kunjungan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Pasien {{ $patient->nama }} belum memiliki riwayat kunjungan ke klinik.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('staff.patients.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali ke Daftar Pasien
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Summary Statistics --}}
            @if($queues->count() > 0)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    @php
                        $stats = [
                            'total' => $queues->count(),
                            'selesai' => $queues->where('status', 'selesai')->count(),
                            'menunggu' => $queues->where('status', 'menunggu')->count(),
                            'dibatalkan' => $queues->where('status', 'dibatalkan')->count(),
                        ];
                    @endphp

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Kunjungan</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                                        <dd class="text-lg font-medium text-green-600">{{ $stats['selesai'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                                        <dd class="text-lg font-medium text-yellow-600">{{ $stats['menunggu'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Dibatalkan</dt>
                                        <dd class="text-lg font-medium text-red-600">{{ $stats['dibatalkan'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Action Panel --}}
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
                        <p class="text-sm text-gray-500">Kelola data pasien {{ $patient->nama }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.patients.edit', $patient) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Data
                        </a>
                        <a href="{{ route('staff.patients.show', $patient) }}"
                           class="bg-sky-500 hover:bg-sky-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail
                        </a>
                        <a href="{{ route('staff.patients.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            Daftar Pasien
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
