<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Detail Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
         <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nama Pasien:</strong>
                        <p>{{ $patient->nama }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">NIK:</strong>
                        <p>{{ $patient->nik }}</p>
                     </div>
                   <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir:</strong>
                        <p>{{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d-m-Y') }}</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</strong>
                        <p>{{ $patient->jenis_kelamin }}</p>
                    </div>
                    <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Alamat:</strong>
                         <p>{{ $patient->alamat }}</p>
                    </div>
                     <div class="mb-4">
                        <strong class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</strong>
                        <p>{{ $patient->no_telepon }}</p>
                    </div>
                   <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Riwayat Penyakit:</strong>
                        <p>{{ $patient->medical_history ?? '-' }}</p>
                   </div>
                     <div class="mb-4">
                         <strong class="block text-gray-700 text-sm font-bold mb-2">Riwayat Antrian Pasien:</strong>
                           @if($patient->queues->isEmpty())
                                  <p>Tidak ada riwayat antrian pasien</p>
                            @else
                                <div class="overflow-x-auto">
                                     <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                             <tr>
                                                 <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                                                 <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                                 <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Pesan</th>
                                                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                             </tr>
                                        </thead>
                                         <tbody class="bg-white divide-y divide-gray-200">
                                             @foreach($patient->queues as $queue)
                                                <tr>
                                                   <td class="px-6 py-4 whitespace-nowrap">{{ $queue->queue_number }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $queue->poli->nama }}</td>
                                                     <td class="px-6 py-4 whitespace-nowrap">{{ $queue->dokter ? $queue->dokter->nama : 'Tidak Ada' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($queue->created_at)->format('d-m-Y H:i:s') }}</td>
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
                                            @endforeach
                                       </tbody>
                                     </table>
                                </div>
                            @endif
                    </div>

                   <div class="flex items-center justify-start">
                           <a href="{{ route('admin.patients.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kembali
                           </a>
                           <a href="{{ route('admin.patients.edit', $patient->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2 focus:outline-none focus:shadow-outline">
                                Edit
                           </a>
                    </div>
                </div>
            </div>
         </div>
    </div>
</x-app-layout>
