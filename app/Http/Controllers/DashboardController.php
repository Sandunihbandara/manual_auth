<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Instrument;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard($user),
            'staff' => $this->staffDashboard($user),
            default => $this->userDashboard($user),
        };
    }

    private function userDashboard($user)
    {
        $department = $user->department;

        $stats = [
            'total_bookings' => Booking::where('user_id', $user->id)->count(),

            'active_bookings' => Booking::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('end_at', '>=', now())
                ->count(),

            'pending_approvals' => Booking::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),

            'available_instruments' => Instrument::where('department', $department)
                ->where('status', 'available')
                ->count(),
        ];

        $upcomingBookings = Booking::with('instrument')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending','approved'])
            ->where('end_at', '>=', now())
            ->orderBy('start_at')
            ->limit(5)
            ->get();

        $recentActivity = Booking::with('instrument')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard.user', compact('user', 'department', 'stats', 'upcomingBookings', 'recentActivity'));
    }

    private function staffDashboard($user)
    {
        $department = $user->department;

        $stats = [
            'total_bookings' => Booking::where('department', $department)->count(),

            'active_bookings' => Booking::where('department', $department)
                ->where('status', 'approved')
                ->where('end_at', '>=', now())
                ->count(),

            'pending_approvals' => Booking::where('department', $department)
                ->where('status', 'pending')
                ->count(),

            'available_instruments' => Instrument::where('department', $department)
                ->where('status', 'available')
                ->count(),
        ];

        $pendingApprovals = Booking::with(['instrument','user'])
            ->where('department', $department)
            ->where('status', 'pending')
            ->orderBy('start_at')
            ->limit(5)
            ->get();

        $maintenanceDueSoon = MaintenanceSchedule::with('instrument')
            ->whereHas('instrument', fn($q) => $q->where('department', $department))
            ->whereIn('status', ['scheduled','in_progress'])
            ->where('starts_at', '>=', now())
            ->where('starts_at', '<=', now()->addDays(7))
            ->orderBy('starts_at')
            ->limit(5)
            ->get();

        return view('dashboard.staff', compact('user', 'department', 'stats', 'pendingApprovals', 'maintenanceDueSoon'));
    }

    private function adminDashboard($user)
    {
        $stats = [
            'total_bookings' => Booking::count(),

            'active_bookings' => Booking::where('status', 'approved')
                ->where('end_at', '>=', now())
                ->count(),

            'pending_approvals' => Booking::where('status', 'pending')->count(),

            'available_instruments' => Instrument::where('status', 'available')->count(),
        ];

        $pendingApprovals = Booking::with(['instrument','user'])
            ->where('status', 'pending')
            ->orderBy('start_at')
            ->limit(8)
            ->get();

        $maintenanceDueSoon = MaintenanceSchedule::with('instrument')
            ->whereIn('status', ['scheduled','in_progress'])
            ->where('starts_at', '>=', now())
            ->where('starts_at', '<=', now()->addDays(7))
            ->orderBy('starts_at')
            ->limit(8)
            ->get();

        return view('dashboard.admin', compact('user', 'stats', 'pendingApprovals', 'maintenanceDueSoon'));
    }
}