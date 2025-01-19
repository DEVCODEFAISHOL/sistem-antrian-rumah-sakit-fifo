<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Detail Staff') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <p class="mt-1 text-sm text-gray-900">{{ $staff->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <p class="mt-1 text-sm text-gray-900">{{ $staff->email }}</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Kembali</a>
        </div>
    </div>
</x-app-layout>
