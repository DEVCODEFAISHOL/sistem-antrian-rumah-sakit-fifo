<x-app-layout> <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{ __('Dashboard Staff Antrian') }} </h2>
    </x-slot>
    <div class="py-12 bg-gradient-to-br from-sky-50 to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-xl mb-8 text-white p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang, Staff!</h1>
                        <p class="text-sky-100 text-lg">Kelola antrian pasien poliklinik dengan mudah dan efisien.</p>
                        <p class="text-sky-200 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/20 rounded-full p-6"> <svg class="w-16 h-16 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg> </div>
                    </div>
                </div>
            </div> <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8"> @php
                $statCards = [
                    ['label' => 'Total Antrian', 'value' => $stats['total'], 'color' => 'sky', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>'],
                    ['label' => 'Menunggu', 'value' => $stats['waiting'], 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['label' => 'Dipanggil', 'value' => $stats['called'], 'color' => 'yellow', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.636 5.636a9 9 0 0112.728 0M12 18h.01"></path>'],
                    ['label' => 'Selesai', 'value' => $stats['completed'], 'color' => 'green', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['label' => 'Dilewati', 'value' => $stats['skipped'], 'color' => 'red', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>'],
                ];
            @endphp @foreach ($statCards as $card)
                    <div
                        class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 border-l-4 border-{{ $card['color'] }}-500 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mt-4 -mr-4 w-16 h-16 bg-{{ $card['color'] }}-100 rounded-full opacity-20">
                        </div>
                        <div class="flex items-center relative z-10">
                            <div class="flex-shrink-0">
                                <div
                                    class="bg-gradient-to-br from-{{ $card['color'] }}-100 to-{{ $card['color'] }}-200 rounded-lg p-3 shadow-inner">
                                    <svg class="w-8 h-8 text-{{ $card['color'] }}-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg> </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ $card['label'] }}</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $card['value'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach </div> <!-- Current Queue & Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8"> <!-- Panggilan Utama -->
                <div
                    class="bg-white rounded-xl shadow-2xl border-2 border-sky-500 flex flex-col items-center justify-center p-8 text-center">
                    @if ($currentQueue)
                        <h3 class="text-xl font-bold text-sky-700 uppercase tracking-wider">
                            {{ $currentQueue->status === 'called' ? 'SEDANG DIPANGGIL' : 'PANGGIL ANTRIAN' }} </h3>
                        <p class="text-8xl font-black text-sky-600 my-4">{{ $currentQueue->queue_number }}</p>
                        <div class="mb-6 text-center">
                            <p class="text-2xl font-bold text-gray-800">{{ $currentQueue->patient->nama }}</p>
                            <p class="text-md text-gray-500">{{ $currentQueue->poli->nama }}</p>
                        </div>
                        <div class="w-full space-y-3">
                            @if ($currentQueue->status === 'waiting')
                                <form action="{{ route('staff.queues.call', $currentQueue->id) }}" method="POST">
                                    @csrf <button type="submit"
                                        class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center text-lg">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-2.236 9.168-5.584C18.354 5.166 18 7.225 18 9.574V11a4 4 0 01-4 4H7.436z">
                                            </path>
                                        </svg> PANGGIL SEKARANG </button> </form>
                            @elseif($currentQueue->status === 'called')
                                <form action="{{ route('staff.queues.complete', $currentQueue->id) }}" method="POST">
                                    @csrf <button type="submit"
                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center text-lg">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg> TANDAI SELESAI </button> </form>
                                @endif <form action="{{ route('staff.queues.skip', $currentQueue->id) }}"
                                    method="POST"> @csrf <button type="submit"
                                        class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                        </svg> LEWATI ANTRIAN </button> </form>
                        </div>
                    @else
                        <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-700">Semua Antrian Selesai</h3>
                        <p class="text-gray-500 mt-2">Tidak ada antrian yang menunggu untuk dipanggil.</p> @endif
                </div> <!-- Informasi Antrian Lainnya -->
                <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 flex flex-col space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 -mb-2 flex items-center"> <svg
                            class="w-6 h-6 text-sky-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg> Detail Antrian </h3> <!-- Terakhir Dipanggil -->
                    <div class="p-5 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="font-semibold text-green-800 mb-2">Terakhir Dipanggil</h4>
                        @if ($lastQueue)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-2xl font-bold text-green-700">{{ $lastQueue->queue_number }}</p>
                                    <p class="text-sm text-green-600 font-medium">{{ $lastQueue->patient->nama }}</p>
                                </div> <span
                                    class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full font-semibold">
                                    {{ \Carbon\Carbon::parse($lastQueue->called_time)->format('H:i') }} </span>
                            </div>
                        @else
                            <p class="text-green-600 italic">Belum ada yang dipanggil hari ini.</p>
                            @endif
                    </div> <!-- Selanjutnya -->
                    <div class="p-5 bg-blue-50 rounded-lg border border-blue-200">
                        <h4 class="font-semibold text-blue-800 mb-2">Antrian Berikutnya</h4>
                        @if ($nextQueue && $currentQueue && $nextQueue->id !== $currentQueue->id)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-2xl font-bold text-blue-700">{{ $nextQueue->queue_number }}</p>
                                    <p class="text-sm text-blue-600 font-medium">{{ $nextQueue->patient->nama }}</p>
                                </div> <span
                                    class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-semibold capitalize">
                                    {{ $nextQueue->priority }} </span>
                            </div>
                        @else
                            <p class="text-blue-600 italic">Tidak ada antrian selanjutnya.</p>
                            @endif
                    </div>
                </div>
            </div> <!-- Daftar Antrian Hari Ini -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center"> <svg class="w-6 h-6 mr-3"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg> Daftar Lengkap Antrian Hari Ini </h3>
                </div>
                <div class="overflow-x-auto">
                    @if ($queues->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-sky-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        No. Antrian</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Nama Pasien</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Poli</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Prioritas</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Waktu Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($queues as $queue)
                                    <tr
                                        class="hover:bg-gray-50 transition-colors duration-150 {{ $currentQueue && $queue->id === $currentQueue->id ? 'bg-sky-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap"><span
                                                class="text-lg font-bold text-sky-600">{{ $queue->queue_number }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $queue->patient->nama }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $queue->patient->nik ?? 'NIK tidak ada' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $queue->poli->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center"> <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ ['berat' => 'bg-red-100 text-red-800', 'sedang' => 'bg-yellow-100 text-yellow-800', 'ringan' => 'bg-green-100 text-green-800'][$queue->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($queue->priority) }} </span> </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center"> <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ ['waiting' => 'bg-blue-100 text-blue-800', 'called' => 'bg-yellow-100 text-yellow-800', 'completed' => 'bg-green-100 text-green-800', 'skipped' => 'bg-red-100 text-red-800'][$queue->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($queue->status) }} </span> </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            {{ $queue->created_at->format('H:i') }} WIB</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-16"> <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Antrian</h3>
                            <p class="mt-1 text-sm text-gray-500">Saat ini belum ada pasien yang mendaftar antrian.</p>
                        </div>
                    @endif
                </div>
            </div> <!-- Footer -->
            <div class="mt-12 text-center text-sm text-gray-500">
                <p>Copyright © {{ date('Y') }} Poliklinik RS Budhi Asih. All Rights Reserved.</p>
                <p class="mt-1">Dibuat oleh Developer esa unggul</p>
            </div>
        </div>
    </div> <!-- Auto-refresh script -->
    <script>
        // Auto refresh halaman setiap 30 detik untuk update real-time setTimeout(function() { location.reload(); }, 30000); // 30000 milidetik = 30 detik
    </script>
</x-app-layout>
