<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\Auth;

class ParticipantDashboardController extends Controller
{
    public function __construct()
    {
        // Role validation is handled by middleware in routes
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get user's registered events (with event details)
        $registeredEvents = EventParticipant::where('user_id', $user->id)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get upcoming events JOINED by user (not global list)
        $upcomingEvents = $registeredEvents
            ->filter(function ($participant) {
                return $participant->event
                    && optional($participant->event->start_date)->isAfter(now());
            })
            ->sortBy(function ($participant) {
                return $participant->event->start_date;
            })
            ->take(5)
            ->values();
        
        // Get user statistics
        $stats = [
            'total_registered' => $registeredEvents->count(),
            'attended_events' => $registeredEvents->where('status', 'attended')->count(),
            'upcoming_events' => $registeredEvents->where('status', 'registered')->count(),
        ];

        return view('participant.dashboard', compact('registeredEvents', 'upcomingEvents', 'stats'));
    }

    /**
     * Display profile settings page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('participant.profile.index', compact('user'));
    }

    /**
     * Update profile settings
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($request->only(['full_name', 'name', 'email', 'phone', 'bio']));

        return redirect()->route('participant.profile')
            ->with('success', 'Profile updated successfully!');
    }
}
