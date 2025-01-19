<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <div class="mb-4">
                        <a href="{{ route('admin.dokters.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Dokter
                        </a>
                    </div>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dokter</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($dokters as $dokter)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dokter->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dokter->spesialisasi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dokter->email }}</td>
                                         <td class="px-6 py-4 whitespace-nowrap">{{ $dokter->telepon }}</td>
                                        <td class="px-6 py-4 ">{{ $dokter->alamat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.dokters.show', $dokter->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <a href="{{ route('admin.dokters.edit', $dokter->id) }}" class="text-yellow-600 hover:text-yellow-900 ml-2">Edit</a>
                                           <form action="{{ route('admin.dokters.destroy', $dokter->id) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap" colspan="5">Tidak ada data dokter.</td>
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
