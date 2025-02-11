<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">
    <!-- Dashboard -->
    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('pasien'))
        @php
            // Tentukan route dashboard berdasarkan role
            $dashboardRoute = Auth::user()->hasRole('admin')
                ? route('admin.dashboard')
                : (Auth::user()->hasRole('staff')
                    ? route('staff.dashboard')
                    : route('patient.dashboard'));
        @endphp

        <x-sidebar.link title="Dashboard" href="{{ $dashboardRoute }}" :isActive="request()->routeIs(['admin.dashboard', 'staff.dashboard', 'patient.dashboard'])">
            <x-slot name="icon">
                <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endif

    <!-- Menu untuk Admin -->
    @if (Auth::user()->hasRole('admin'))
        <!-- Kelola Antrian -->
        <x-sidebar.dropdown title="Kelola Antrian" :active="Str::startsWith(request()->route()->uri(), 'admin/queues')">
            <x-slot name="icon">
                <x-heroicon-o-clipboard-list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Daftar Antrian" href="{{ route('admin.queues.index') }}" :active="request()->routeIs('admin.queues.index')" />
            <x-sidebar.sublink title="Tambah Antrian" href="{{ route('admin.queues.create') }}" :active="request()->routeIs('admin.queues.create')" />
        </x-sidebar.dropdown>

        <!-- Kelola Pasien -->
        <x-sidebar.dropdown title="Kelola Pasien" :active="Str::startsWith(request()->route()->uri(), 'admin/patients')">
            <x-slot name="icon">
                <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Daftar Pasien" href="{{ route('admin.patients.index') }}" :active="request()->routeIs('admin.patients.index')" />
            <x-sidebar.sublink title="Tambah Pasien" href="{{ route('admin.patients.create') }}" :active="request()->routeIs('admin.patients.create')" />
            <x-sidebar.sublink title="Riwayat Pasien" href="{{ route('admin.patients.history') }}" :active="request()->routeIs('admin.patients.history')" />
        </x-sidebar.dropdown>

        <!-- Kelola Poli -->
        <x-sidebar.dropdown title="Kelola Poli" :active="Str::startsWith(request()->route()->uri(), 'admin/polis')">
            <x-slot name="icon">
                <x-heroicon-o-home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Daftar Poli" href="{{ route('admin.polis.index') }}" :active="request()->routeIs('admin.polis.index')" />
            <x-sidebar.sublink title="Tambah Poli" href="{{ route('admin.polis.create') }}" :active="request()->routeIs('admin.polis.create')" />
        </x-sidebar.dropdown>

        <!-- Kelola Dokter -->
        <x-sidebar.dropdown title="Kelola Dokter" :active="Str::startsWith(request()->route()->uri(), 'admin/dokters')">
            <x-slot name="icon">
                <x-heroicon-o-user-circle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Daftar Dokter" href="{{ route('admin.dokters.index') }}" :active="request()->routeIs('admin.dokters.index')" />
            <x-sidebar.sublink title="Tambah Dokter" href="{{ route('admin.dokters.create') }}" :active="request()->routeIs('admin.dokters.create')" />
        </x-sidebar.dropdown>

        <!-- Kelola Staff -->
        <x-sidebar.dropdown title="Kelola Staff" :active="Str::startsWith(request()->route()->uri(), 'admin/staff')">
            <x-slot name="icon">
                <x-heroicon-o-user-group class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Daftar Staff" href="{{ route('admin.staff.index') }}" :active="request()->routeIs('admin.staff.index')" />
            <x-sidebar.sublink title="Tambah Staff" href="{{ route('admin.staff.create') }}" :active="request()->routeIs('admin.staff.create')" />
        </x-sidebar.dropdown>

        <!-- Monitoring & Reporting -->
        <x-sidebar.dropdown title="Monitoring & Reporting" :active="Str::startsWith(request()->route()->uri(), 'admin/reports')">
            <x-slot name="icon">
                <x-heroicon-o-chart-bar class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink title="Laporan Kunjungan" href="{{ route('admin.reports.visits') }}"
                :active="request()->routeIs('admin.reports.visits')" />

        </x-sidebar.dropdown>
    @endif

    <!-- Menu untuk Staff -->
    @if (Auth::user()->hasRole('staff'))
        <!-- Kelola Antrian -->
        <x-sidebar.dropdown title="Kelola Antrian" :active="Str::startsWith(request()->route()->uri(), 'staff/queues')">
            <x-slot name="icon">
                <x-heroicon-o-clipboard-list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
            <x-sidebar.sublink title="Daftar Antrian" href="{{ route('staff.queues.index') }}" :active="request()->routeIs('staff.queues.index')" />
            <x-sidebar.sublink title="Tambah Antrian" href="{{ route('staff.queues.create') }}" :active="request()->routeIs('staff.queues.create')" />

        </x-sidebar.dropdown>

        <!-- Kelola Pasien -->
        <!-- Kelola Pasien -->
        <x-sidebar.dropdown title="Kelola Pasien" :active="Str::startsWith(request()->route()->uri(), 'staff/patients')">
            <x-slot name="icon">
                <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
            <x-sidebar.sublink title="Daftar Pasien" href="{{ route('staff.patients.index') }}" :active="request()->routeIs('staff.patients.index')" />
            {{-- <x-sidebar.sublink title="Riwayat Pasien" href="{{ route('staff.patients.history') }}"
                :active="request()->routeIs('staff.patients.history')" /> --}}
        </x-sidebar.dropdown>
    @endif
</x-perfect-scrollbar>
