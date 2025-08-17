<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Waktu Tunggu Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifikasi Session -->
            <div class="mb-4">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">Berhasil</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                         <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">Gagal</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Konten Utama -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        Laporan Waktu Tunggu Pasien per Hari Ini
                    </h3>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No Antrian
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Pasien
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Waktu Janji Temu
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Waktu Dipanggil
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Waktu Tunggu (Menit)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($queues as $queue)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $queue['queue_number'] }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $queue['patient_name'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $queue['appointment_time'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $queue['called_time'] }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold">
                                            {{ $queue['waiting_time'] }} Menit
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data waktu tunggu yang tersedia untuk hari ini.
                                        </td>
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
