<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function create()
    {
        $instruments = Instrument::orderBy('department')->orderBy('name')->get();
        return view('maintenance.create', compact('instruments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instrument_id' => ['required','exists:instruments,id'],
            'starts_at' => ['required','date'],
            'ends_at' => ['required','date','after:starts_at'],
            'type' => ['required','string','max:255'],
            // remind_at is optional; if not given you can compute later
            'remind_at' => ['nullable','date','before:starts_at'],
        ]);

        MaintenanceSchedule::create([
            'instrument_id' => $validated['instrument_id'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'type' => $validated['type'],
            'status' => 'scheduled',
            'remind_at' => $validated['remind_at'] ?? null,
            'created_by' => $request->user()->id,
        ]);

        // Optional: set instrument status to maintenance immediately if starts_at <= now
        // (Better: automate with scheduler later)
        return redirect()->route('maintenance.create')->with('success', 'Maintenance scheduled.');
    }
}