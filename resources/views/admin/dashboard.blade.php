<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Dashboard Admin - Poliklinik Khusus Penyakit Dalam Rumah Sakit Budhi Asih') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-gray-800">
        <!-- Section: Statistik Antrian -->
         <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
             <!-- Total Antrian Hari Ini -->
             <div class="p-6 bg-blue-100 rounded-lg shadow-sm dark:bg-blue-900">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Total Antrian Hari Ini</h3>
                 <p class="text-2xl font-bold text-blue-800 dark:text-blue-200">{{ $totalQueuesToday }}</p>
             </div>

            <!-- Total Antrian yang Sudah Dipanggil -->
             <div class="p-6 bg-green-100 rounded-lg shadow-sm dark:bg-green-900">
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Total Antrian Dipanggil</h3>
                <p class="text-2xl font-bold text-green-800 dark:text-green-200">{{ $totalCalledQueues }}</p>
            </div>

             <!-- Antrian Terakhir Dipanggil -->
             <div class="p-6 bg-yellow-100 rounded-lg shadow-sm dark:bg-yellow-900">
                 <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">Antrian Terakhir</h3>
                 <p class="text-2xl font-bold text-yellow-800 dark:text-yellow-200">{{ $lastQueue ? $lastQueue->queue_number : 'Tidak ada' }}</p>
             </div>

           <!-- Antrian Selanjutnya -->
           <div class="p-6 bg-purple-100 rounded-lg shadow-sm dark:bg-purple-900">
               <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200">Antrian Selanjutnya</h3>
                <p class="text-2xl font-bold text-purple-800 dark:text-purple-200">{{ $nextQueue ? $nextQueue->queue_number : 'Tidak ada' }}</p>
            </div>
        </div>

        <!-- Section: Card Antrian -->
         <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
             <!-- Card Antrian Saat Ini (Seluruh Prioritas) -->
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Antrian Saat Ini (Seluruh Prioritas)</h3>
                 <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ $currentQueue ? $currentQueue->queue_number : 'Tidak ada' }}</p>
               @if ($currentQueue)
                     <form action="{{ route('admin.queues.call', $currentQueue->id) }}" method="POST" class="mt-4">
                         @csrf
                         <button type="submit"
                            class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Panggil Antrian</button>
                        <form action="{{ route('admin.queues.skip', $currentQueue->id) }}" method="POST"
                             class="inline-block ml-2">
                             @csrf
                             <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Lewati</button>
                         </form>
                    </form>
                 @endif
            </div>

            <!-- Card Antrian Saat Ini (Ringan - Sedang) -->
              <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-700">
                 <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Antrian Saat Ini (Ringan - Sedang)</h3>
                  <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ $currentQueueLightMedium ? $currentQueueLightMedium->queue_number : 'Tidak ada' }}</p>
                @if ($currentQueueLightMedium)
                      <form action="{{ route('admin.queues.call', $currentQueueLightMedium->id) }}" method="POST"
                        class="mt-4">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Panggil Antrian</button>
                        <form action="{{ route('admin.queues.skip', $currentQueueLightMedium->id) }}" method="POST"
                           class="inline-block ml-2">
                            @csrf
                             <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Lewati</button>
                         </form>
                    </form>
                @endif
             </div>


            <!-- Card Antrian Saat Ini (Berat) -->
             <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Antrian Saat Ini (Berat)</h3>
                 <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                   {{ $currentQueueHeavy ? $currentQueueHeavy->queue_number : 'Tidak ada' }}</p>
                @if ($currentQueueHeavy)
                     <form action="{{ route('admin.queues.call', $currentQueueHeavy->id) }}" method="POST"
                        class="mt-4">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Panggil Antrian</button>
                         <form action="{{ route('admin.queues.skip', $currentQueueHeavy->id) }}" method="POST"
                            class="inline-block ml-2">
                            @csrf
                             <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Lewati</button>
                        </form>
                   </form>
               @endif
             </div>
         </div>

        <!-- Section: Daftar Antrian -->
         <div class="mb-8">
            <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Daftar Antrian</h3>
            <div class="overflow-x-auto bg-white rounded-lg shadow-md dark:bg-gray-700">
                <table class="min-w-full">
                   <thead class="bg-gray-50 dark:bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">No</th>
                           <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Nama Pasien</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">No Antrian</th>
                           <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Jam Pesan</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Jam Dipanggil</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Prioritas</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Keterangan</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Status</th>
                             <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Aksi</th>
                        </tr>
                    </thead>
                   <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                       @forelse ($queues as $queue)
                           <tr>
                               <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $queue->patient->nama }}</td>
                               <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $queue->queue_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    @if ($queue->appointment_time)
                                          {{ \Carbon\Carbon::parse($queue->appointment_time)->format('H:i') }}
                                     @else
                                         {{ $queue->created_at->format('H:i') }}
                                    @endif
                                </td>
                                 <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                     @if ($queue->called_time)
                                          {{ \Carbon\Carbon::parse($queue->called_time)->format('H:i') }}
                                     @else
                                          -
                                     @endif
                                  </td>
                                 <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ ucfirst($queue->priority) }}</td>
                                 <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $queue->keterangan ?? '-' }}</td>
                                 <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ ucfirst($queue->status) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                     @if ($queue->status === 'called')
                                         <form action="{{ route('admin.queues.complete', $queue->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                              <button type="submit"
                                               class="px-2 py-1 text-white bg-green-500 rounded-md hover:bg-green-600">Selesai</button>
                                          </form>
                                           <form action="{{ route('admin.queues.skip', $queue->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                   class="px-2 py-1 text-white bg-red-500 rounded-md hover:bg-red-600">Skip</button>
                                          </form>
                                     @endif
                                 </td>
                            </tr>
                        @empty
                           <tr>
                                 <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200" colspan="9">Tidak ada data antrian hari ini.</td>
                             </tr>
                       @endforelse
                   </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
         <div class="mt-8 text-center text-gray-600 dark:text-gray-400">
           <p>Copyright © 2024 Poliklinik Khusus Penyakit Dalam Rumah Sakit Budhi Asih. All Rights Reserved.</p>
           <p>Created by Ravizza Magfur Sadanand.</p>
        </div>
    </div>
</x-app-layout>
