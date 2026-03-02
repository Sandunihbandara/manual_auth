@extends('layouts.app')

@section('title', 'My Bookings - AcademiCore')

@section('content')

  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">My Bookings</h1>

    <a href="{{ route('instruments.index') }}"
       class="px-4 py-2 rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold">
      + New Booking
    </a>
  </div>

  <div class="space-y-4">

    @forelse($bookings as $booking)
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">

        <div class="flex items-start justify-between gap-4">

          <div>
            <div class="font-semibold text-lg">
              {{ $booking->instrument->name }}
            </div>

            <div class="text-sm text-white/70 mt-1">
              {{ $booking->start_at->format('M d, Y h:i A') }}
              →
              {{ $booking->end_at->format('M d, Y h:i A') }}
            </div>
          </div>

          <div>
            <span class="px-3 py-1 rounded-xl text-xs border
              {{ $booking->status === 'approved' ? 'bg-green-500/10 border-green-400/30 text-green-200' :
                 ($booking->status === 'pending' ? 'bg-yellow-500/10 border-yellow-400/30 text-yellow-200' :
                 ($booking->status === 'rejected' ? 'bg-red-500/10 border-red-400/30 text-red-200' :
                 'bg-gray-500/10 border-gray-400/30 text-gray-200')) }}">
              {{ strtoupper($booking->status) }}
            </span>
          </div>

        </div>

        @if($booking->decision_note)
          <div class="mt-3 text-sm text-white/60 border-t border-white/10 pt-3">
            <strong>Note:</strong> {{ $booking->decision_note }}
          </div>
        @endif

      </div>

    @empty
      <div class="bg-black/40 border border-white/10 rounded-2xl p-6 text-center text-white/60">
        You have not made any bookings yet.
      </div>
    @endforelse

  </div>

@endsection