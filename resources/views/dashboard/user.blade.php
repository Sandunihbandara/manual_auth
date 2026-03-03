@extends('layouts.app')

@section('title', 'Dashboard - AcademiCore')

@section('content')
  <div class="space-y-8">

    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl font-bold">Welcome back, {{ $user->name }}!</h1>
        <p class="text-white/70 mt-2">{{ $department }}</p>
      </div>

      <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-sm text-white/70">
        <div class="font-semibold text-white">Today</div>
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div class="text-white/90 mt-1">{{ now()->format('h:i A') }}</div>
      </div>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Total bookings</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['total_bookings'] }}</div>
        <div class="text-white/60 text-xs mt-2">All time</div>
      </div>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Active bookings</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['active_bookings'] }}</div>
        <div class="text-white/60 text-xs mt-2">Approved & upcoming</div>
      </div>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Pending approvals</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['pending_approvals'] }}</div>
        <div class="text-white/60 text-xs mt-2">Waiting staff/admin</div>
      </div>

      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="text-white/70 text-sm">Available instruments</div>
        <div class="text-3xl font-bold mt-2">{{ $stats['available_instruments'] }}</div>
        <div class="text-white/60 text-xs mt-2">In your department</div>
      </div>
    </div>

    {{-- Quick actions --}}
    <div class="bg-black/30 border border-white/10 rounded-2xl p-5">
  <div class="text-white/80 font-semibold">Quick Actions</div>

  {{-- Search instruments --}}
  <form method="GET" action="{{ route('instruments.index') }}" class="mt-4 flex gap-2">
    <input
      name="search"
      value="{{ request('search') }}"
      placeholder="Search instruments by name (e.g., meter, oscilloscope)"
      class="flex-1 rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
    >
    <button
      class="rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold px-5"
      type="submit"
    >
      Search
    </button>
  </form>

  {{-- Buttons --}}
  <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
    <a href="{{ route('instruments.index') }}"
       class="rounded-xl bg-indigo-500 hover:bg-indigo-600 transition px-4 py-3 font-semibold text-center">
      Browse Instruments
    </a>

    <a href="{{ route('bookings.mine') }}"
       class="rounded-xl bg-white/10 hover:bg-white/15 transition border border-white/10 px-4 py-3 font-semibold text-center">
      My Bookings
    </a>

    <a href="{{ route('help.index') }}"
       class="rounded-xl bg-white/10 hover:bg-white/15 transition border border-white/10 px-4 py-3 font-semibold text-center">
      Help & Support
    </a>
  </div>
  </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      {{-- Upcoming --}}
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="font-semibold">Upcoming Bookings</div>
        <div class="mt-4 space-y-3">
          @forelse($upcomingBookings as $b)
            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
              <div class="font-semibold">{{ $b->instrument->name }}</div>
              <div class="text-sm text-white/70 mt-1">
                {{ $b->start_at->format('M d, Y h:i A') }} → {{ $b->end_at->format('h:i A') }}
              </div>
              <div class="mt-2 text-xs">
                <span class="px-2 py-1 rounded-lg border
                  {{ $b->status==='pending' ? 'bg-yellow-500/10 border-yellow-400/30 text-yellow-200' : 'bg-green-500/10 border-green-400/30 text-green-200' }}">
                  {{ strtoupper($b->status) }}
                </span>
              </div>
            </div>
          @empty
            <div class="text-white/60 text-sm">No upcoming bookings.</div>
          @endforelse
        </div>
      </div>

      {{-- Recent activity --}}
      <div class="bg-black/40 border border-white/10 rounded-2xl p-5">
        <div class="font-semibold">Recent Activity</div>
        <div class="mt-4 space-y-3">
          @forelse($recentActivity as $a)
            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
              <div class="font-semibold">{{ $a->instrument->name }}</div>
              <div class="text-sm text-white/70 mt-1">
                Booking {{ $a->status }} • {{ $a->created_at->diffForHumans() }}
              </div>
            </div>
          @empty
            <div class="text-white/60 text-sm">No activity yet.</div>
          @endforelse
        </div>
      </div>
    </div>

  </div>
@endsection