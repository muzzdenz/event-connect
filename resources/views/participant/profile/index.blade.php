@extends('participant.layout')

@section('title', 'Profile Settings - Event Connect')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - User Info and Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- User Info Section -->
                    <div class="p-6 text-center border-b border-gray-200">
                        <!-- User Avatar -->
                        <div class="w-24 h-24 bg-pink-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <span class="text-4xl font-bold text-gray-700">
                                {{ strtoupper(substr($user->full_name ?? $user->name, 0, 1)) }}
                            </span>
                        </div>
                        <!-- User Name -->
                        <h3 class="text-lg font-bold text-gray-900 mb-1">
                            {{ $user->full_name ?? $user->name }}
                        </h3>
                        <!-- User Email -->
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </div>

                    <!-- Navigation Links -->
                    <div class="p-4 space-y-2">
                        <a href="{{ route('participant.profile') }}" 
                           class="block px-4 py-2 bg-pink-100 text-gray-900 rounded-lg font-medium">
                            My Profile
                        </a>
                        <a href="#" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            Transaction History
                        </a>
                    </div>

                    <!-- Sign Out Button -->
                    <div class="p-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Content Area - Profile Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Profile</h2>
                        
                        <form action="{{ route('participant.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <!-- Phone Number Field -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <div class="flex">
                                        <div class="px-4 py-2 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg flex items-center text-gray-700">
                                            +62
                                        </div>
                                        <input type="text" 
                                               name="phone" 
                                               id="phone" 
                                               value="{{ old('phone', $user->phone ?? '') }}" 
                                               placeholder="8123456789"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Full Name Field -->
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" 
                                           name="full_name" 
                                           id="full_name" 
                                           value="{{ old('full_name', $user->full_name ?? $user->name) }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <!-- Display Name Field -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Tampilan</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <!-- Bio Field -->
                                <div>
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea name="bio" 
                                              id="bio" 
                                              rows="4" 
                                              placeholder="Tell us about yourself..."
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('bio', $user->bio ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-6 flex justify-end">
                                <button type="submit" 
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

