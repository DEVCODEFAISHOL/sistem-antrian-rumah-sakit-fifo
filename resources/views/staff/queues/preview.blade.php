<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Tiket Antrian</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8fafc;
            color: #334756;
        }

        .container {
            max-width: 800px; /* Lebar container yang lebih baik */
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

         .header h1 {
                font-size: 2.5rem; /* Ukuran font yang lebih besar untuk judul utama */
                font-weight: 700; /* Ketebalan font yang lebih kuat */
                color: #1e3a8a; /* Warna judul yang lebih menarik */
                letter-spacing: 0.05rem;
                margin-bottom: 0.5rem;
        }

        .ticket-number-box {
            border: 2px solid #cbd5e1;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
             margin-bottom: 1.5rem;
        }

        .ticket-number {
            font-size: 2.5rem;
            font-weight: 600;
            color: #214179; /* Warna nomor tiket yang lebih menonjol */
        }

        .info-box {
            width: 100%;
             padding: 1.25rem;
            margin: 1rem auto;
            border: 1px solid #e2e8f0; /* Border yang lebih tipis dan lembut */
            border-radius: 0.5rem;
        }

         .info-box p {
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .info-box span {
            font-weight: 500;
            color: #4a5568; /* Warna teks yang lebih lembut untuk label */
        }

        .print-button {
            background-color: #43a047; /* Warna tombol yang lebih menarik */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
            display: inline-block; /* Jadikan inline-block untuk margin auto */
            margin-bottom: 1rem;
        }

        .print-button:hover {
            background-color: #388e3c;
        }


       footer {
            text-align: center;
            padding-top: 2rem; /* Margin di bagian atas footer */
            color: #6b7280; /* Warna teks footer yang lebih lembut */
        }

        footer p {
            margin: 0.25rem 0;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        footer .date-printed {
           margin-top: 1rem;
            font-size: 0.75rem;
             color: #9ca3af; /* Warna teks date printed yang lebih pudar */
        }
            /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 1rem;
            }
           .header h1 {
                font-size: 2rem;
            }

             .ticket-number {
                font-size: 2rem; /* Ukuran font nomor antrian lebih kecil untuk layar yang lebih kecil */
            }
        }
    </style>
</head>

<body class="flex justify-center min-h-screen">
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>REVIEW TIKET ANTRIAN</h1>
        </div>

        <!-- Kotak Nomor Antrian -->
        <div class="ticket-number-box">
            <p class="ticket-number">{{ $queue->queue_number }}</p>
        </div>

         <!-- Informasi Antrian -->
        <div class="info-box">
            <p><span>Nama Pemesan:</span> {{ $queue->patient->nama ?? '-' }}</p>
            <p><span>Poli:</span> {{ $queue->poli->nama ?? '-' }}</p>
            <p><span>Dokter:</span> {{ $queue->dokter->nama ?? '-' }}</p>
            <p><span>Waktu Pesan:</span> {{ $queue->created_at->format('d M Y H:i:s') }}</p>
            <p><span>Waktu Janji Temu:</span> {{ $queue->appointment_time }}</p>
            <p><span>Jenis Tiket:</span> {{ $queue->priority }}</p>
        </div>

       <!-- Tombol Cetak -->
       <div class="mt-4">
            <a href="{{ route('staff.queues.print', $queue->id) }}" target="_blank" class="print-button">Cetak Tiket</a>
        </div>

        <!-- Footer -->
        <footer>
            <p>Selamat datang di Rumah Sakit Budhi Asih.</p>
            <p>Semoga lekas sembuh, jaga kesehatan ibu dan bapak sekalian.</p>
            <p>Salam hangat dari kami.</p>
            <p class="date-printed">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
        </footer>

    </div>
</body>

</html>
