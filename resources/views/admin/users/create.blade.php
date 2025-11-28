<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - Event Connect Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-calendar-alt text-2xl mr-2" style="color: #B22234;"></i>
                        <span class="text-xl font-bold text-gray-800">Event Connect Admin</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ Auth::user()->full_name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 min-h-screen" style="background-color: #B22234;">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-sm"></i>
                    </div>
                    <h2 class="text-white text-lg font-semibold">Admin Dashboard</h2>
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-white/80 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center bg-white/20 text-white px-3 py-2 rounded">
                        <i class="fas fa-users mr-3"></i>Users
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="flex items-center text-white/80 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fas fa-calendar mr-3"></i>Events
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center text-white/80 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fas fa-tags mr-3"></i>Categories
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="flex items-center text-white/80 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fas fa-chart-bar mr-3"></i>Analytics
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6">
                <div class="flex items-center mb-4">
                    <a href="{{ route('admin.users.index') }}" style="color: #B22234;" class="hover:opacity-80 mr-4">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
                </div>
                <p class="text-gray-600">Add a new user to the system</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('name') border-red-500 @enderror" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('full_name') border-red-500 @enderror" 
                                   required>
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('email') border-red-500 @enderror" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <select name="role" id="role" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('role') border-red-500 @enderror" 
                                    required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Participant</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                            <input type="password" name="password" id="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('password') border-red-500 @enderror" 
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2" 
                                   required>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- is_organizer removed; organizer determined by role -->
                    </div>

                    <!-- Bio -->
                    <div class="mt-6">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea name="bio" id="bio" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 admin-input focus:ring-2 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                style="background-color: #B22234;" class="px-4 py-2 text-white rounded-md hover:opacity-90">
                            <i class="fas fa-save mr-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

