<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend API Unavailable - Event Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <!-- 502 Icon -->
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-red-100">
                <i class="fas fa-server text-red-600 text-3xl"></i>
            </div>
            
            <!-- Error Message -->
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">502</h1>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Backend API Tidak Dapat Diakses</h2>
                <p class="text-gray-600 mb-4">
                    {{ $exception->getMessage() ?? 'Tidak dapat terhubung ke backend API server.' }}
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left text-sm text-gray-700">
                    <p class="font-semibold mb-2"><i class="fas fa-info-circle mr-2"></i>Langkah-langkah:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Pastikan backend API server sedang berjalan</li>
                        <li>Periksa konfigurasi <code class="bg-gray-200 px-1 rounded">API_BASE_URL</code> di file <code class="bg-gray-200 px-1 rounded">.env</code></li>
                        <li>Pastikan backend API dapat diakses di: <code class="bg-gray-200 px-1 rounded">{{ config('services.backend.base_url') }}</code></li>
                    </ol>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <button onclick="window.location.reload()" 
                   class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
                
                <a href="{{ url('/') }}" 
                   class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 inline-block">
                    <i class="fas fa-home mr-2"></i>Kembali ke Home
                </a>
            </div>

            <!-- Help Text -->
            <div class="mt-8 text-sm text-gray-500">
                <p>Jika masalah berlanjut, hubungi administrator sistem.</p>
            </div>
        </div>
    </div>
</body>
</html>



