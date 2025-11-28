<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Dashboard - Event Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-red-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Website Name on Left -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <i class="fas fa-calendar-alt text-white text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-white">Event Connect</span>
                    </a>
                </div>
                
                <!-- Navigation Tabs -->
                <div class="flex items-center space-x-1 mx-auto">
                    <a href="{{ route('home') }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'bg-red-700 text-white' : 'bg-white text-gray-900 hover:bg-gray-100' }}">
                        Home
                    </a>
                    <a href="{{ route('events.index', ['explore' => true]) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('events.index') ? 'bg-red-700 text-white' : 'bg-white text-gray-900 hover:bg-gray-100' }}">
                        Explore
                    </a>
                    <a href="{{ route('participant.dashboard') }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('participant.dashboard') ? 'bg-red-700 text-white' : 'bg-white text-gray-900 hover:bg-gray-100' }}">
                        Participation
                    </a>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-2">
                    @auth
                        <span class="text-white text-sm font-medium mr-2">
                            Welcome, {{ Auth::user()->full_name ?? Auth::user()->name }}
                        </span>
                    @endauth
                    <div class="flex items-center space-x-2">
                        <button class="w-8 h-8 bg-white rounded-md text-gray-900 hover:bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-bell text-sm"></i>
                        </button>
                        <div class="relative">
                            <button class="w-8 h-8 bg-white rounded-md text-gray-900 hover:bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-user text-sm"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <a href="{{ route('participant.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-3xl font-bold text-gray-900">Participant Dashboard</h1>
            <p class="mt-2 text-gray-600">Manage your event participations and activities</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-[#4B0F0F] text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Events Joined</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_registered'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-certificate text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Events Attended</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['attended_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-star text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Your Upcoming Events</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['upcoming_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bell text-[#F4B6B6] text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Role</dt>
                                <dd class="text-lg font-medium text-gray-900">Participant</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Upcoming Events (User Joined) -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Your Upcoming Events</h3>
                        <div class="space-y-4">
                            @forelse ($upcomingEvents as $participant)
                                @php($event = $participant->event)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $event->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $event->start_date->format('F d, Y • H:i') }}</p>
                                            <p class="text-sm text-gray-600">{{ $event->location ?? 'Online Event' }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Joined
                                            </span>
                                            <a href="{{ route('events.show', $event->id) }}" class="text-[#4B0F0F] hover:opacity-80">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">You haven't joined any upcoming events yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('events.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#F4B6B6] hover:bg-[#ef9fa0]">
                                <i class="fas fa-search mr-2"></i>Browse Events
                            </a>
                            <a href="{{ route('attendance.scanner') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-qrcode mr-2"></i>Scan QR Code
                            </a>
                            <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-user mr-2"></i>Edit Profile
                            </a>
                            <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-certificate mr-2"></i>My Certificates
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Joined "Design Thinking Workshop"</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Downloaded certificate for "Tech Meetup"</p>
                                    <p class="text-xs text-gray-500">1 day ago</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Submitted feedback for "Marketing Seminar"</p>
                                    <p class="text-xs text-gray-500">3 days ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.relative button');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const menu = this.nextElementSibling;
                    if (menu) {
                        // Close all other dropdowns
                        document.querySelectorAll('.relative .absolute').forEach(otherMenu => {
                            if (otherMenu !== menu) {
                                otherMenu.classList.add('hidden');
                            }
                        });
                        // Toggle current dropdown
                        menu.classList.toggle('hidden');
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.relative .absolute').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
