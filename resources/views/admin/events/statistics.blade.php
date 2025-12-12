<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Kehadiran - {{ $event->title }} - Event Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-white/80 hover:bg-white/10">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Statistik Kehadiran</h2>
                        <p class="text-gray-600">{{ $event->title }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.events.show', $event->id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Event
                        </a>
                        <a href="{{ route('admin.events.participants', $event->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-users mr-2"></i>Lihat Peserta
                        </a>
                    </div>
                </div>
            </header>

            <!-- Statistics Cards -->
            <div class="p-6">
                <!-- Event Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Event</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Mulai</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Selesai</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lokasi</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $event->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-block px-3 py-1 text-sm rounded-full
                                @if($event->status === 'published') bg-green-100 text-green-800
                                @elseif($event->status === 'draft') bg-yellow-100 text-yellow-800
                                @elseif($event->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Participants -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Peserta</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $statistics['total_participants'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">dari {{ $statistics['quota'] }} kuota</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $statistics['quota_filled'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">{{ $statistics['quota_filled'] }}% terisi</p>
                        </div>
                    </div>

                    <!-- Attended -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Sudah Hadir</p>
                                <p class="text-3xl font-bold text-green-600">{{ $statistics['attended'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $statistics['attendance_rate'] }}% dari total</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Not Attended -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Belum Hadir</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ $statistics['not_attended'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Terdaftar namun belum scan</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Rate -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Tingkat Kehadiran</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $statistics['attendance_rate'] }}%</p>
                                <p class="text-xs text-gray-500 mt-1">Dari yang terdaftar</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Pie Chart -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Kehadiran</h3>
                        <canvas id="attendanceChart"></canvas>
                    </div>

                    <!-- Bar Chart -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Peserta</h3>
                        <canvas id="participantChart"></canvas>
                    </div>
                </div>

                <!-- Participants Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Peserta</h3>
                        <div class="flex gap-2">
                            <button onclick="exportCSV()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-download mr-2"></i>Export CSV
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Daftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Hadir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($participants as $index => $participant)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $participant->user->name ?? $participant->user_name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $participant->user->email ?? $participant->user_email ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($participant->status === 'attended')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Hadir
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i> Belum Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ isset($participant->created_at) ? \Carbon\Carbon::parse($participant->created_at)->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ isset($participant->attended_at) ? \Carbon\Carbon::parse($participant->attended_at)->format('d M Y H:i') : '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2"></i>
                                        <p>Belum ada peserta yang terdaftar</p>
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

    <script>
        // Pie Chart - Attendance Distribution
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Belum Hadir', 'Pending'],
                datasets: [{
                    data: [{{ $statistics['attended'] }}, {{ $statistics['not_attended'] }}, {{ $statistics['pending'] }}],
                    backgroundColor: ['#10B981', '#F59E0B', '#6B7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Bar Chart - Participant Statistics
        const participantCtx = document.getElementById('participantChart').getContext('2d');
        new Chart(participantCtx, {
            type: 'bar',
            data: {
                labels: ['Total Peserta', 'Hadir', 'Belum Hadir'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $statistics['total_participants'] }}, {{ $statistics['attended'] }}, {{ $statistics['not_attended'] }}],
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Export CSV Function
        function exportCSV() {
            let csv = 'No,Nama,Email,Status,Waktu Daftar,Waktu Hadir\n';
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cols = row.querySelectorAll('td');
                if (cols.length > 1) {
                    const rowData = [
                        index + 1,
                        cols[1].textContent.trim(),
                        cols[2].textContent.trim(),
                        cols[3].textContent.trim(),
                        cols[4].textContent.trim(),
                        cols[5].textContent.trim()
                    ];
                    csv += rowData.join(',') + '\n';
                }
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'statistik_kehadiran_{{ $event->title }}.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>
</html>
