@extends('layouts.app')

@section('title', 'Book Instrument')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Book: {{ $instrument->name }}</h1>

  <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="instrument_id" value="{{ $instrument->id }}">

    <div>
      <label class="text-sm text-white/80">Start</label>
      <input type="datetime-local" name="start_at"
             min="{{ now()->format('Y-m-d\TH:i') }}"
             class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white">
    </div>

    <div>
      <label class="text-sm text-white/80">End</label>
      <input type="datetime-local" name="end_at"
                min="{{ now()->format('Y-m-d\TH:i') }}"
             class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white">
    </div>

    <button class="w-full rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold py-3">
      Submit Booking Request
    </button>
  </form>
@endsection

<script>
    function updateMinDateTime() {
        const now = new Date();
        now.setSeconds(0);
        now.setMilliseconds(0);

        const localISOTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0,16);

        document.getElementById('start_at').min = localISOTime;
    }

    updateMinDateTime();
    setInterval(updateMinDateTime, 60000);
</script>