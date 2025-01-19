<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #334756;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f8fafc;
        }

        .ticket-container {
            width: 80%;
            max-width: 600px;
            background: white;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .header h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1e3a8a;
            letter-spacing: 0.05rem;
            margin-bottom: 0.5rem;
        }


        .ticket-number-container {
            display: flex;
            justify-content: center; /* Center the content horizontally */
             margin-bottom: 1.5rem;
        }

        .ticket-number {
             font-size: 3rem; /* Larger size */
            text-align: center; /* Center align text */
            font-weight: 600;
            color: #214179;
             white-space: nowrap; /* Prevent text from wrapping */
        }

        .info-box {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin: 1rem auto;
        }

        .info-box p {
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .info-box span {
            font-weight: 500;
            color: #4a5568;
        }

        footer {
            text-align: center;
            padding-top: 2rem;
            color: #6b7280;
        }

        footer p {
            margin: 0.25rem 0;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        footer .date-printed {
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #9ca3af;
        }


        @media print {
            body {
                background: white;
                display: block;
                min-height: auto;
                margin: 0;
                padding: 0;
            }

            .ticket-container {
                width: 100%;
                max-width: none;
                box-shadow: none;
                margin: 0;
                border-radius: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body class="print:bg-white">
    <div class="ticket-container">
        <!-- Header -->
        <div class="header">
            <h1>TIKET ANTRIAN</h1>
        </div>

        <!-- Nomor Antrian Tanpa Kotak -->
         <div class="ticket-number-container">
            <p class="ticket-number">{{ $ticket_number }}</p>
        </div>

        <!-- Informasi Antrian -->
        <div class="info-box">
            <p><span>Nama Pemesan:</span> {{ $queue->patient->nama ?? '-' }}</p>
            <p><span>Poli:</span> {{ $queue->poli->nama ?? '-' }}</p>
            <p><span>Jenis Tiket:</span> {{ $queue->priority }}</p>
        </div>


        <!-- Footer -->
        <footer>
            <p>Selamat datang di Rumah Sakit Budhi Asih.</p>
            <p>Semoga lekas sembuh, jaga kesehatan ibu dan bapak sekalian.</p>
            <p>Salam hangat dari kami.</p>
            <p class="date-printed">Dicetak pada: {{ $currentDateTime->format('d M Y H:i:s') }}</p>
        </footer>
    </div>
</body>

</html>
