<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Instrument::query();

        // Users + Staff see only their department instruments
        if (in_array($user->role, ['user','staff'], true) && $user->department) {
            $query->where('department', $user->department);
        }

        // Admin sees all instruments (no filter)

        $instruments = $query->orderBy('name')->get();

        return view('instruments.index', compact('instruments', 'user'));
    }
}