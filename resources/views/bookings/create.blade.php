@extends('layouts.app')

@section('title', 'Book Instrument')

@section('content')

  {{-- ✅ Unavailable time slots should be ABOVE the form (and inside content) --}}
  @if($approved->count())
    <div class="mb-6 bg-red-500/5 border border-red/10 rounded-2xl p-4">
      <div class="font-semibold mb-2">Unavailable (Already Approved) Time Slots</div>
      <ul class="text-sm text-white/70 space-y-1">
        @foreach($approved as $a)
          <li>
            {{ \Carbon\Carbon::parse($a->start_at)->format('M d, Y h:i A') }}
            →
            {{ \Carbon\Carbon::parse($a->end_at)->format('h:i A') }}
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  <h1 class="text-2xl font-bold mb-4">Book: {{ $instrument->name }}</h1>

  <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="instrument_id" value="{{ $instrument->id }}">

    <div>
      <label class="text-sm text-white/80">Start</label>
      <input
        id="start_at"
        type="datetime-local"
        name="start_at"
        min="{{ now()->format('Y-m-d\TH:i') }}"
        class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
      >

      {{-- ✅ Show backend error under the field --}}
      @error('start_at')
        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="text-sm text-white/80">End</label>
      <input
        id="end_at"
        type="datetime-local"
        name="end_at"
        min="{{ now()->format('Y-m-d\TH:i') }}"
        class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white"
      >

      @error('end_at')
        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button class="w-full rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold py-3">
      Submit Booking Request
    </button>
  </form>

  {{-- ✅ Script should also be inside content (or use @push if you have it) --}}
  <script>
    function updateMinDateTime() {
      const now = new Date();
      now.setSeconds(0);
      now.setMilliseconds(0);

      const localISOTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);

      const start = document.getElementById('start_at');
      const end = document.getElementById('end_at');

      if (start) start.min = localISOTime;
      if (end) end.min = localISOTime;
    }

    updateMinDateTime();
    setInterval(updateMinDateTime, 60000);
  </script>

@endsection