<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Waktu Tunggu Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Laporan Waktu Tunggu Pasien</h3>
                     @if(session('success'))
                        <div class="bg-green-200 text-green-800 border border-green-400 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                      @if(session('error'))
                    <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                  <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Antrian</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Janji Temu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Dipanggil</th>
                                   <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Tunggu (Menit)</th>
                                 </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($queues as $queue)
                                    <tr>
                                         <td class="px-6 py-4 whitespace-nowrap">{{ $queue['queue_number'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue['patient_name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue['appointment_time'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue['called_time'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $queue['waiting_time'] }}</td>
                                    </tr>
                                @empty
                                     <tr>
                                         <td class="px-6 py-4 whitespace-nowrap" colspan="5">Tidak ada data waktu tunggu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
