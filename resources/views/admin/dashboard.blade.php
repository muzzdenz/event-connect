@extends('admin.layout')

@section('title', 'Event Organizer Dashboard')
@section('page-title', 'My Event Dashboard')
@section('page-description', 'Welcome back! Here\'s what\'s happening with your events and participants.')

@section('content')

            <!-- Stats Cards -->
            <div class="p-0 md:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                    <!-- Total Users -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="p-2 md:p-3 rounded-full" style="background-color: rgba(178, 34, 52, 0.1); color: var(--color-primary);">
                                <i class="fas fa-users text-xl md:text-2xl"></i>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-600">Event Participants</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                                <p class="text-xs md:text-sm text-green-600">+{{ $stats['this_month_participants'] }} this month</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Events -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="p-2 md:p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-calendar-alt text-xl md:text-2xl"></i>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-600">My Events</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_events']) }}</p>
                                <p class="text-xs md:text-sm text-green-600">+{{ $stats['this_month_events'] }} this month</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Events -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="p-2 md:p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clock text-xl md:text-2xl"></i>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-600">Active Events</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ number_format($stats['active_events']) }}</p>
                                <p class="text-xs md:text-sm text-gray-500">{{ $stats['completed_events'] }} completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Organizers -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="p-2 md:p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-crown text-xl md:text-2xl"></i>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-600">Total Participants</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_participants']) }}</p>
                                <p class="text-xs md:text-sm text-gray-500">{{ $stats['total_categories'] }} categories</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                    <!-- Monthly Events Chart -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Events Created This Year</h3>
                        <canvas id="monthlyEventsChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Category Distribution -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Events by Category</h3>
                        <canvas id="categoryChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Recent Activities & Top Events -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                    <!-- Recent Activities -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
                        <div class="space-y-4">
                            @forelse($recentActivities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-{{ $activity['color'] ?? 'blue' }}-100 flex items-center justify-center">
                                        <i class="fas fa-{{ $activity['icon'] ?? 'info-circle' }} text-{{ $activity['color'] ?? 'blue' }}-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">{{ $activity['message'] ?? 'Activity' }}</p>
                                    <p class="text-xs text-gray-500">{{ isset($activity['time']) ? $activity['time']->diffForHumans() : 'Recently' }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-bell-slash text-4xl mb-4"></i>
                                <p>No recent activities</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top Events -->
                    <div class="bg-white rounded-lg shadow p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Top Events by Participants</h3>
                        <div class="space-y-4">
                            @forelse($topEvents as $event)
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title ?? 'Untitled Event' }}</p>
                                    <p class="text-xs text-gray-500">by {{ $event->organizer->full_name ?? 'Unknown' }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600">{{ $event->participants_count ?? 0 }} participants</span>
                                    <div class="w-2 h-2 rounded-full" style="background-color: {{ $event->category->color ?? '#3B82F6' }}"></div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-4"></i>
                                <p>No events yet</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

    <script>
        // Monthly Events Chart
        const monthlyCtx = document.getElementById('monthlyEventsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyEvents['months']),
                datasets: [{
                    label: 'Events Created',
                    data: @json($monthlyEvents['events']),
                    borderColor: 'rgb(178, 34, 52)',
                    backgroundColor: 'rgba(178, 34, 52, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryStats->pluck('name')),
                datasets: [{
                    data: @json($categoryStats->pluck('count')),
                    backgroundColor: @json($categoryStats->pluck('color'))
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
