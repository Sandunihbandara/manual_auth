<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    // list pending bookings for staff/admin
    public function index(Request $request)
    {
        $user = $request->user();

        $q = Booking::with(['user','instrument'])
            ->where('status', 'pending')
            ->orderBy('start_at');

        // staff sees only own department; admin sees all
        if ($user->role === 'staff') {
            $q->where('department', $user->department);
        }

        $pending = $q->get();

        // quick minimal view for now
        return view('approvals.index', compact('pending'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $user = $request->user();

        // staff can approve only their department
        if ($user->role === 'staff' && $booking->department !== $user->department) {
            abort(403);
        }

        $validated = $request->validate([
            'decision_note' => ['nullable','string','max:2000'],
        ]);

        // IMPORTANT: when approving, now we must ensure it doesn't conflict with APPROVED bookings
        $conflict = Booking::where('instrument_id', $booking->instrument_id)
            ->where('status', 'approved')
            ->where('id', '!=', $booking->id)
            ->where('start_at', '<', $booking->end_at)
            ->where('end_at', '>', $booking->start_at)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['approve' => 'Cannot approve: overlaps an existing approved booking.']);
        }

        $booking->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'decision_note' => $validated['decision_note'] ?? null,
        ]);

        return back()->with('success', 'Booking approved.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($user->role === 'staff' && $booking->department !== $user->department) {
            abort(403);
        }

        $validated = $request->validate([
            'decision_note' => ['required','string','max:2000'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'decision_note' => $validated['decision_note'],
        ]);

        return back()->with('success', 'Booking rejected.');
    }
}