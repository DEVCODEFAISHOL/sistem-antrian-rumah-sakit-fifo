<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian - {{ $queue->queue_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: 80mm 110mm;
            margin: 0;
        }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            width: 80mm;
            height: 110mm;
            margin: 0;
            padding: 0;
        }
        .ticket-container {
            width: 100%;
            height: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="bg-white">
    <div class="ticket-container flex flex-col">
        <!-- Header -->
        <div class="text-center mb-2">
            <h1 class="text-lg font-bold text-blue-900">RUMAH SAKIT BUDHI ASIH</h1>
        </div>

        <!-- Nomor Antrian -->
        <div class="flex justify-center mb-3">
            <div class="text-4xl font-bold text-blue-800 border-2 border-blue-800 rounded px-6 py-1 bg-blue-50">
                {{ $queue->queue_number }}
            </div>
        </div>

        <!-- Informasi Pasien -->
        <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-sm mb-3">
            <span class="text-gray-600 font-medium">Nama:</span>
            <span class="text-gray-900 font-semibold">{{ $queue->patient->nama ?? '-' }}</span>

            <span class="text-gray-600 font-medium">Poli:</span>
            <span class="text-gray-900 font-semibold">{{ $queue->poli->nama ?? '-' }}</span>

            <span class="text-gray-600 font-medium">Prioritas:</span>
            <span>
                @if($queue->priority == 'ringan')
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full">Ringan</span>
                @elseif($queue->priority == 'sedang')
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded-full">Sedang</span>
                @elseif($queue->priority == 'berat')
                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded-full">Berat</span>
                @else
                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full">{{ ucfirst($queue->priority) }}</span>
                @endif
            </span>
        </div>

        <!-- Divider -->
        <div class="border-t border-dashed border-gray-300 my-1"></div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-600 mt-1">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Mohon tunggu sampai nomor antrian dipanggil</p>
            <p class="mt-1 text-gray-500 text-xs">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 300);
        }
    </script>
</body>
</html>
