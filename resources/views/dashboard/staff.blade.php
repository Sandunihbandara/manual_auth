@extends('layouts.app')

@section('title', 'Staff Dashboard - AcademiCore')

@section('content')
  <div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-bold">Staff Dashboard</h1>
        <p class="text-white/70 mt-2">
          Department: <span class="text-white font-semibold">{{ $department }}</span>
        </p>
      </div>

      <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-sm text-white/70">
        <div class="font-semibold text-white">Today</div>
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div class="text-white/90 mt-1">{{ now()->format('h:i A') }}</div>
      </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <a href="{{ route('approvals.index') }}" class="block bg-black/40 border border-white/10 rounded-2xl p-5 hover:bg-white/5 transition">
        <div class="text-white/70 text-sm">Pending approvals</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['pending_approvals'] }}</div>
        <div class="text-white/60 text-xs mt-2">Click to review</div>
      </a>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Active bookings</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['active_bookings'] }}</div>
        <div class="text-white/60 text-xs mt-2">Approved & ongoing/upcoming</div>
      </div>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Total bookings</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['total_bookings'] }}</div>
        <div class="text-white/60 text-xs mt-2">Department total</div>
      </div>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Available instruments</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['available_instruments'] }}</div>
        <div class="text-white/60 text-xs mt-2">In {{ $department }}</div>
      </div>
    </div>

    {{-- Lists --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

      {{-- Pending approvals list --}}
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="flex items-center justify-between">
          <div class="font-semibold">Pending Requests</div>
          <a href="{{ route('approvals.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200 font-semibold">
            View all
          </a>
        </div>

        <div class="mt-4 space-y-3">
          @forelse($pendingApprovals as $b)
            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
              <div class="font-semibold">{{ $b->instrument->name }}</div>
              <div class="text-sm text-white/70 mt-1">
                {{ $b->user->name }} • {{ $b->start_at->format('M d, h:i A') }} → {{ $b->end_at->format('h:i A') }}
              </div>

              <div class="mt-3 flex gap-2">
                <form method="POST" action="{{ route('approvals.approve', $b) }}">
                  @csrf
                  <button class="px-3 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-sm font-semibold">
                    Approve
                  </button>
                </form>

                <form method="POST" action="{{ route('approvals.reject', $b) }}">
                  @csrf
                  <input type="hidden" name="decision_note" value="Rejected by staff">
                  <button class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-sm font-semibold">
                    Reject
                  </button>
                </form>
              </div>
            </div>
          @empty
            <div class="text-white/60 text-sm">No pending requests.</div>
          @endforelse
        </div>
      </div>

      {{-- Maintenance due soon --}}
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="font-semibold">Maintenance Due Soon (7 days)</div>

        <div class="mt-4 space-y-3">
          @forelse($maintenanceDueSoon as $m)
            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
              <div class="font-semibold">{{ $m->instrument->name }}</div>
              <div class="text-sm text-white/70 mt-1">
                {{ $m->starts_at->format('M d, h:i A') }} → {{ $m->ends_at->format('h:i A') }}
              </div>
              <div class="mt-2 text-xs">
                <span class="px-2 py-1 rounded-lg border bg-yellow-500/10 border-yellow-400/30 text-yellow-200">
                  {{ strtoupper($m->status) }}
                </span>
              </div>
            </div>
          @empty
            <div class="text-white/60 text-sm">No upcoming maintenance.</div>
          @endforelse
        </div>
      </div>

    </div>

  </div>
@endsection