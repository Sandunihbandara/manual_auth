@extends('layouts.app')

@section('title', 'Instruments')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Instruments</h1>

    @if($user->role === 'admin')
      <a href="#" class="px-4 py-2 rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold">
        + Add Instrument
      </a>
    @endif
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($instruments as $ins)
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="font-semibold text-lg">{{ $ins->name }}</div>
            <div class="text-sm text-white/70 mt-1">{{ $ins->department }}</div>
          </div>

          <span class="text-xs px-2 py-1 rounded-lg border
            {{ $ins->status === 'available' ? 'bg-green-500/10 border-green-400/30 text-green-200' :
               ($ins->status === 'maintenance' ? 'bg-yellow-500/10 border-yellow-400/30 text-yellow-200' :
               'bg-red-500/10 border-red-400/30 text-red-200') }}">
            {{ strtoupper($ins->status) }}
          </span>
        </div>

        <div class="mt-4">
          @if($ins->status === 'available')
            <a href="{{ route('bookings.create', $ins->id) }}"
               class="block text-center rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold py-2">
              Book Now
            </a>
          @else
            <button disabled
              class="block w-full text-center rounded-xl bg-white/10 border border-white/10 text-white/40 font-semibold py-2 cursor-not-allowed">
              Not Available
            </button>
          @endif
        </div>
      </div>
    @empty
      <div class="text-white/60">No instruments found.</div>
    @endforelse
  </div>
@endsection