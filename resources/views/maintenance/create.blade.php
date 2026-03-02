<!doctype html>
<html>
<head>
  <title>Schedule Maintenance</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-900 text-white p-6">
  <h1 class="text-2xl font-bold">Schedule Instrument Maintenance</h1>

  @if(session('success'))
    <div class="mt-4 p-3 rounded bg-green-500/10 border border-green-400/20 text-green-200">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="mt-4 p-3 rounded bg-red-500/10 border border-red-400/20 text-red-200">
      <ul class="list-disc pl-6">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('maintenance.store') }}" class="mt-6 space-y-4 max-w-xl">
    @csrf

    <div>
      <label class="text-sm text-white/80">Instrument</label>
      <select name="instrument_id" class="mt-1 w-full bg-white/10 border border-white/10 rounded px-3 py-2">
        @foreach($instruments as $i)
          <option value="{{ $i->id }}" class="bg-slate-900">{{ $i->department }} — {{ $i->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="text-sm text-white/80">Type</label>
      <input name="type" value="{{ old('type', 'calibration') }}"
        class="mt-1 w-full bg-white/10 border border-white/10 rounded px-3 py-2">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
      <div>
        <label class="text-sm text-white/80">Starts at</label>
        <input type="datetime-local" name="starts_at"
          class="mt-1 w-full bg-white/10 border border-white/10 rounded px-3 py-2">
      </div>

      <div>
        <label class="text-sm text-white/80">Ends at</label>
        <input type="datetime-local" name="ends_at"
          class="mt-1 w-full bg-white/10 border border-white/10 rounded px-3 py-2">
      </div>
    </div>

    <div>
      <label class="text-sm text-white/80">Remind at (optional)</label>
      <input type="datetime-local" name="remind_at"
        class="mt-1 w-full bg-white/10 border border-white/10 rounded px-3 py-2">
      <p class="text-xs text-white/50 mt-1">Example: set 1 day before maintenance starts.</p>
    </div>

    <button class="px-5 py-2 rounded bg-indigo-500 hover:bg-indigo-600 font-semibold">Schedule</button>
  </form>
</body>
</html>