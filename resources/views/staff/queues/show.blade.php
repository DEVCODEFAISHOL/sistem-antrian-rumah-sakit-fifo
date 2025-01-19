<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Antrian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nomor Antrian:</strong>
                        <p>{{ $queue->queue_number }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Pasien:</strong>
                        <p>{{ $queue->patient->name }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Poli:</strong>
                        <p>{{ $queue->poli->nama }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Dokter:</strong>
                         <p>{{ $queue->dokter ? $queue->dokter->nama : 'Tidak ada' }}</p>
                     </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Prioritas:</strong>
                        <p>{{ $queue->priority }}</p>
                     </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Waktu Janji Temu:</strong>
                        <p>{{ $queue->appointment_time ? $queue->appointment_time->format('H:i') : '-' }}</p>
                    </div>
                     <div class="mb-4">
                       <strong class="block text-gray-700 text-sm font-bold mb-2">Keterangan:</strong>
                         <p>{{ $queue->keterangan }}</p>
                     </div>
                    <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Tanggal Periksa:</strong>
                         <p>{{ $queue->checkup_date->format('d-m-Y') }}</p>
                   </div>
                   <div class="mb-4">
                      <strong class="block text-gray-700 text-sm font-bold mb-2">Jenis Kunjungan:</strong>
                         <p>{{ $queue->jenis_kunjungan }}</p>
                    </div>
                     <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Keluhan:</strong>
                         <p>{{ $queue->complaint }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Darurat:</strong>
                         <p>{{ $queue->is_emergency ? 'Ya' : 'Tidak' }}</p>
                   </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Status:</strong>
                           <p><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                          @if($queue->status == 'waiting') bg-yellow-100 text-yellow-800
                                            @elseif($queue->status == 'called') bg-blue-100 text-blue-800
                                            @elseif($queue->status == 'skipped') bg-gray-100 text-gray-800
                                             @elseif($queue->status == 'completed') bg-green-100 text-green-800
                                           @endif">
                                                    {{ $queue->status }}
                                               </span></p>
                    </div>
                    <div class="flex items-center justify-start">
                         <a href="{{ route('staff.queues.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                           </a>
                           <a href="{{ route('staff.queues.edit', $queue->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2 focus:outline-none focus:shadow-outline">
                                Edit
                           </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
