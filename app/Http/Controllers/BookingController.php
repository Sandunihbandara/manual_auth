<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Instrument;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // user creates a booking request
    public function store(Request $request)
    {
        
        $user = $request->user();

        $validated = $request->validate([
            'instrument_id' => ['required','integer','exists:instruments,id'],
            'start_at' => ['required','date','after_or_equal:now'],
            'end_at' => ['required','date','after:start_at'],
        ]);

        $instrument = Instrument::findOrFail($validated['instrument_id']);

        // Optional rule: user can book only their department instruments (admin/staff can override later)
        if ($user->role === 'user' && $user->department && $instrument->department !== $user->department) {
            return back()->withErrors(['instrument_id' => 'You can only book instruments in your department.']);
        }

        // Block booking if instrument is maintenance/unavailable (requesting should be blocked)
        if (in_array($instrument->status, ['unavailable','maintenance'], true)) {
            return back()->withErrors(['instrument_id' => 'This instrument is not available right now.']);
        }

        // RULE #1: only APPROVED bookings block time
        $overlapsApproved = Booking::where('instrument_id', $instrument->id)
            ->where('status', 'approved')
            ->where('start_at', '<', $validated['end_at'])
            ->where('end_at', '>', $validated['start_at'])
            ->exists();

        if ($overlapsApproved) {
            return back()->withErrors(['start_at' => 'This time range is already booked (approved booking).']);
        }

        // Also block if it overlaps scheduled/in_progress maintenance
        $overlapsMaintenance = MaintenanceSchedule::where('instrument_id', $instrument->id)
            ->whereIn('status', ['scheduled','in_progress'])
            ->where('starts_at', '<', $validated['end_at'])
            ->where('ends_at', '>', $validated['start_at'])
            ->exists();

        if ($overlapsMaintenance) {
            return back()->withErrors(['start_at' => 'This instrument has maintenance during that time.']);
        }

        Booking::create([
            'user_id' => $user->id,
            'instrument_id' => $instrument->id,
            'department' => $user->department ?? $instrument->department,
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking request submitted (pending approval).');
    }

    public function myBookings(Request $request)
    {
    $user = $request->user();

    $bookings = Booking::with('instrument')
        ->where('user_id', $user->id)
        ->orderByDesc('start_at')
        ->get();

    return view('bookings.mine', compact('bookings'));
    }

    public function create(Instrument $instrument)
    {
    return view('bookings.create', compact('instrument'));
    }

}