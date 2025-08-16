<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Antrian Hari Ini') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium">Total Antrian</h3>
                            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                        </div>
                        <div class="text-blue-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium">Menunggu</h3>
                            <p class="text-2xl font-bold">{{ $stats['waiting'] }}</p>
                        </div>
                        <div class="text-yellow-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-500 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium">Dipanggil</h3>
                            <p class="text-2xl font-bold">{{ $stats['called'] }}</p>
                        </div>
                        <div class="text-indigo-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium">Selesai</h3>
                            <p class="text-2xl font-bold">{{ $stats['completed'] }}</p>
                        </div>
                        <div class="text-green-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium">Dilewati</h3>
                            <p class="text-2xl font-bold">{{ $stats['skipped'] }}</p>
                        </div>
                        <div class="text-gray-200">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kuota Poli Cards -->
            @if($poliQuotas->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status Kuota Poli Hari Ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($poliQuotas as $quota)
                    <div class="bg-white rounded-lg shadow p-4 border-l-4
                        {{ $quota->current_count >= $quota->max_quota ? 'border-red-500' : ($quota->current_count >= $quota->max_quota * 0.8 ? 'border-yellow-500' : 'border-green-500') }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $quota->poli->nama }}</h4>
                                <p class="text-sm text-gray-600">{{ $quota->poli->kode_poli }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $quota->current_count >= $quota->max_quota ? 'bg-red-100 text-red-800' : ($quota->current_count >= $quota->max_quota * 0.8 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ $quota->current_count }}/{{ $quota->max_quota }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $quota->current_count >= $quota->max_quota ? 'bg-red-500' : ($quota->current_count >= $quota->max_quota * 0.8 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                     style="width: {{ ($quota->current_count / $quota->max_quota) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Action Buttons -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('staff.queues.create') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Antrian
                            </a>

                            <a href="{{ route('staff.queues.history') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Riwayat Antrian
                            </a>
                        </div>

                        <!-- Auto Refresh Toggle -->
                        <div class="flex items-center space-x-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="autoRefresh" class="form-checkbox h-4 w-4 text-green-600">
                                <span class="ml-2 text-sm text-gray-700">Auto Refresh (30s)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="bg-green-200 text-green-800 border border-green-400 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Filter dan Search -->
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <select id="statusFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Status</option>
                                <option value="waiting">Menunggu</option>
                                <option value="called">Dipanggil</option>
                                <option value="completed">Selesai</option>
                                <option value="skipped">Dilewati</option>
                            </select>
                        </div>
                        <div>
                            <select id="poliFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Poli</option>
                                @foreach($queues->unique('poli_id') as $queue)
                                    @if($queue->poli)
                                        <option value="{{ $queue->poli->id }}">{{ $queue->poli->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="text" id="searchPatient" placeholder="Cari nama pasien..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <button onclick="resetFilters()" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Reset Filter
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="queueTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. Antrian
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pasien
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Poli
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dokter
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Janji
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estimasi Tunggu
                                    </th>
                                    <th class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($queues as $queue)
                                    <tr class="queue-row hover:bg-gray-50"
                                        data-status="{{ $queue->status }}"
                                        data-poli="{{ $queue->poli_id }}"
                                        data-patient="{{ strtolower($queue->patient->name) }}">

                                        <!-- Nomor Antrian -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $queue->queue_number }}
                                                </div>
                                                @if($queue->is_emergency)
                                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        DARURAT
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Pasien -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $queue->patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $queue->patient->nik }} | {{ $queue->jenis_kunjungan }}
                                            </div>
                                        </td>

                                        <!-- Poli -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $queue->poli->nama ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $queue->poli->kode_poli ?? '-' }}</div>
                                        </td>

                                        <!-- Dokter -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $queue->dokter ? 'Dr. ' . $queue->dokter->nama : 'Tidak ada' }}
                                            </div>
                                            @if($queue->dokter)
                                                <div class="text-sm text-gray-500">{{ $queue->dokter->spesialisasi }}</div>
                                            @endif
                                        </td>

                                        <!-- Prioritas -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($queue->priority == 'ringan') bg-green-100 text-green-800
                                                @elseif($queue->priority == 'sedang') bg-yellow-100 text-yellow-800
                                                @elseif($queue->priority == 'berat') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($queue->priority) }}
                                            </span>
                                        </td>

                                        <!-- Waktu Janji -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $queue->appointment_time ? $queue->appointment_time->format('H:i') : '-' }}
                                            @if($queue->called_time)
                                                <div class="text-xs text-blue-600">Dipanggil: {{ $queue->called_time }}</div>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($queue->status == 'waiting') bg-yellow-100 text-yellow-800
                                                @elseif($queue->status == 'called') bg-blue-100 text-blue-800
                                                @elseif($queue->status == 'skipped') bg-gray-100 text-gray-800
                                                @elseif($queue->status == 'completed') bg-green-100 text-green-800
                                                @endif">
                                                @if($queue->status == 'waiting') Menunggu
                                                @elseif($queue->status == 'called') Dipanggil
                                                @elseif($queue->status == 'skipped') Dilewati
                                                @elseif($queue->status == 'completed') Selesai
                                                @endif
                                            </span>
                                        </td>

                                        <!-- Estimasi Tunggu -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($queue->estimated_waiting_time && in_array($queue->status, ['waiting', 'called']))
                                                {{ $queue->estimated_waiting_time }} menit
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Detail -->
                                                <a href="{{ route('staff.queues.show', $queue->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900" title="Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Call Button -->
                                                @if($queue->status == 'waiting')
                                                    <form action="{{ route('staff.queues.call', $queue->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900" title="Panggil">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Complete Button -->
                                                @if($queue->status == 'called')
                                                    <form action="{{ route('staff.queues.complete', $queue->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Selesai">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Skip Button -->
                                                @if(in_array($queue->status, ['waiting', 'called']))
                                                    <form action="{{ route('staff.queues.skip', $queue->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-orange-600 hover:text-orange-900" title="Lewati"
                                                                onclick="return confirm('Yakin ingin melewati antrian ini?')">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Edit -->
                                                @if(in_array($queue->status, ['waiting', 'called']))
                                                    <a href="{{ route('staff.queues.edit', $queue->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                <!-- Print -->
                                                <a href="{{ route('staff.queues.print', $queue->id) }}" target="_blank"
                                                    class="text-purple-600 hover:text-purple-900" title="Print">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('staff.queues.destroy', $queue->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500" colspan="9">
                                            <div class="flex flex-col items-center py-8">
                                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada antrian</h3>
                                                <p class="mt-1 text-sm text-gray-500">Belum ada antrian untuk hari ini.</p>
                                                <div class="mt-6">
                                                    <a href="{{ route('staff.queues.create') }}"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        Tambah Antrian
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination or Additional Info -->
                    @if($queues->count() > 0)
                        <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                            <div>
                                Menampilkan {{ $queues->count() }} antrian dari total {{ $stats['total'] }} antrian hari ini
                            </div>
                            <div>
                                Last updated: <span id="lastUpdated">{{ now()->format('H:i:s') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto refresh functionality
            let autoRefreshInterval;
            const autoRefreshCheckbox = document.getElementById('autoRefresh');
            const lastUpdatedSpan = document.getElementById('lastUpdated');

            autoRefreshCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    autoRefreshInterval = setInterval(function() {
                        window.location.reload();
                    }, 30000); // 30 seconds
                } else {
                    clearInterval(autoRefreshInterval);
                }
            });

            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            const poliFilter = document.getElementById('poliFilter');
            const searchPatient = document.getElementById('searchPatient');

            function applyFilters() {
                const statusValue = statusFilter.value.toLowerCase();
                const poliValue = poliFilter.value;
                const searchValue = searchPatient.value.toLowerCase();
                const rows = document.querySelectorAll('.queue-row');

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    const poli = row.getAttribute('data-poli');
                    const patient = row.getAttribute('data-patient');

                    let showRow = true;

                    // Filter by status
                    if (statusValue && status !== statusValue) {
                        showRow = false;
                    }

                    // Filter by poli
                    if (poliValue && poli !== poliValue) {
                        showRow = false;
                    }

                    // Filter by patient name
                    if (searchValue && !patient.includes(searchValue)) {
                        showRow = false;
                    }

                    row.style.display = showRow ? '' : 'none';
                });
            }

            statusFilter.addEventListener('change', applyFilters);
            poliFilter.addEventListener('change', applyFilters);
            searchPatient.addEventListener('input', applyFilters);

            // Reset filters function
            window.resetFilters = function() {
                statusFilter.value = '';
                poliFilter.value = '';
                searchPatient.value = '';
                applyFilters();
            };

            // Update last updated time
            function updateLastUpdatedTime() {
                const now = new Date();
                lastUpdatedSpan.textContent = now.toLocaleTimeString('id-ID', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }

            // Update time every second
            setInterval(updateLastUpdatedTime, 1000);

            // Sound notification for new queue (optional)
            // You can implement WebSocket or polling for real-time updates

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + N for new queue
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    window.location.href = "{{ route('staff.queues.create') }}";
                }
                // F5 for refresh
                if (e.key === 'F5') {
                    updateLastUpdatedTime();
                }
            });

            // Tooltip initialization (if you're using a tooltip library)
            // Initialize any tooltip library here

            // Success/Error message auto-hide
            setTimeout(function() {
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
    @endpush
</x-app-layout>
