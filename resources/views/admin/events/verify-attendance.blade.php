<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Kehadiran - {{ $event->title }} - Event Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <div class="w-64 shadow-lg" style="background-color: #B22234;">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Event Connect</h1>
                        <p class="text-white/80 text-xs">Event Organizer</p>
                    </div>
                </div>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white/80 hover:bg-white/10">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 text-white bg-white/20 border-r-4 border-white">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Events
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 text-white/80 hover:bg-white/10">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Verify Kehadiran Peserta</h2>
                        <p class="text-gray-600">{{ $event->title }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.events.show', $event->id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <a href="{{ route('admin.events.statistics', $event->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-chart-bar mr-2"></i>Lihat Statistik
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                <!-- Event Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Event</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="text-base font-semibold text-gray-800">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lokasi</p>
                            <p class="text-base font-semibold text-gray-800">{{ $event->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kuota</p>
                            <p class="text-base font-semibold text-gray-800">{{ $event->quota }} peserta</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-block px-3 py-1 text-sm rounded-full
                                @if($event->status === 'published') bg-green-100 text-green-800
                                @elseif($event->status === 'draft') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- QR Scanner -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-qrcode mr-2 text-blue-600"></i>
                            Scan QR Code Peserta
                        </h3>
                        
                        <div class="mb-4">
                            <div id="qr-reader" class="w-full border-2 border-gray-300 rounded-lg overflow-hidden"></div>
                        </div>

                        <div class="flex gap-2">
                            <button id="startScanBtn" onclick="startScanner()" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-play mr-2"></i>Mulai Scan
                            </button>
                            <button id="stopScanBtn" onclick="stopScanner()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" style="display: none;">
                                <i class="fas fa-stop mr-2"></i>Stop Scan
                            </button>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>Cara Menggunakan
                            </h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>1. Klik "Mulai Scan" untuk mengaktifkan kamera</li>
                                <li>2. Arahkan kamera ke QR code peserta</li>
                                <li>3. Sistem akan otomatis memverifikasi kehadiran</li>
                                <li>4. Hasil verifikasi akan muncul di panel sebelah kanan</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Scan Results -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-list-check mr-2 text-green-600"></i>
                            Hasil Verifikasi
                        </h3>

                        <!-- Statistics Counter -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600">Berhasil Diverifikasi</p>
                                <p class="text-3xl font-bold text-green-700" id="successCount">0</p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <p class="text-sm text-red-600">Gagal / Duplikat</p>
                                <p class="text-3xl font-bold text-red-700" id="failedCount">0</p>
                            </div>
                        </div>

                        <!-- Results List -->
                        <div id="resultsList" class="space-y-3 max-h-96 overflow-y-auto">
                            <div class="text-center text-gray-400 py-8">
                                <i class="fas fa-qrcode text-4xl mb-2"></i>
                                <p>Scan QR code untuk memulai verifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Scans Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Scan Terakhir</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody id="scansTableBody" class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada scan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let html5QrcodeScanner = null;
        let successCount = 0;
        let failedCount = 0;

        function startScanner() {
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            };

            html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", config, false);
            html5QrcodeScanner.render(onScanSuccess, onScanError);

            document.getElementById('startScanBtn').style.display = 'none';
            document.getElementById('stopScanBtn').style.display = 'block';
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
            }
            document.getElementById('startScanBtn').style.display = 'block';
            document.getElementById('stopScanBtn').style.display = 'none';
        }

        async function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scanned: ${decodedText}`);
            
            // Verify attendance via API
            try {
                const response = await fetch('{{ route("admin.events.process-verification", $event->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        qr_code: decodedText
                    })
                });

                const data = await response.json();

                if (data.success) {
                    successCount++;
                    addResult(true, data.data?.user_name || 'Peserta', data.message);
                    addToTable(data.data?.user_name || 'Peserta', data.data?.user_email || '-', 'success');
                } else {
                    failedCount++;
                    addResult(false, 'Unknown', data.message);
                    addToTable('Unknown', '-', 'failed', data.message);
                }

                document.getElementById('successCount').textContent = successCount;
                document.getElementById('failedCount').textContent = failedCount;

            } catch (error) {
                failedCount++;
                addResult(false, 'Unknown', 'Terjadi kesalahan: ' + error.message);
                document.getElementById('failedCount').textContent = failedCount;
            }
        }

        function onScanError(error) {
            // Handle scan error silently
            console.warn(`QR scan error: ${error}`);
        }

        function addResult(success, name, message) {
            const resultsList = document.getElementById('resultsList');
            
            // Remove placeholder
            if (resultsList.querySelector('.text-gray-400')) {
                resultsList.innerHTML = '';
            }

            const resultDiv = document.createElement('div');
            resultDiv.className = `p-4 rounded-lg border-l-4 ${success ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500'}`;
            resultDiv.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${success ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600'} text-xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="font-semibold ${success ? 'text-green-800' : 'text-red-800'}">${name}</p>
                        <p class="text-sm ${success ? 'text-green-600' : 'text-red-600'}">${message}</p>
                        <p class="text-xs text-gray-500 mt-1">${new Date().toLocaleTimeString('id-ID')}</p>
                    </div>
                </div>
            `;
            
            resultsList.insertBefore(resultDiv, resultsList.firstChild);

            // Keep only last 10 results
            while (resultsList.children.length > 10) {
                resultsList.removeChild(resultsList.lastChild);
            }
        }

        function addToTable(name, email, status, message = '') {
            const tableBody = document.getElementById('scansTableBody');
            
            // Remove placeholder
            if (tableBody.querySelector('td[colspan="4"]')) {
                tableBody.innerHTML = '';
            }

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${new Date().toLocaleTimeString('id-ID')}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${email}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${status === 'success' 
                        ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i>Berhasil</span>'
                        : `<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800"><i class="fas fa-times mr-1"></i>${message || 'Gagal'}</span>`
                    }
                </td>
            `;
            
            tableBody.insertBefore(row, tableBody.firstChild);

            // Keep only last 20 entries
            while (tableBody.children.length > 20) {
                tableBody.removeChild(tableBody.lastChild);
            }
        }

        // Auto start scanner on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                startScanner();
            }, 500);
        });
    </script>
</body>
</html>
