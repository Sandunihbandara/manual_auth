<!doctype html>
<html>
<head>
  <title>Pending Approvals</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-900 text-white p-6">
  <h1 class="text-2xl font-bold">Pending Approvals</h1>

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

  <div class="mt-6 space-y-3">
    @forelse($pending as $b)
      <div class="p-4 rounded-xl bg-white/5 border border-white/10">
        <div class="font-semibold">{{ $b->instrument->name }} ({{ $b->department }})</div>
        <div class="text-white/70 text-sm">
          {{ $b->start_at->format('Y-m-d H:i') }} → {{ $b->end_at->format('Y-m-d H:i') }}
        </div>
        <div class="text-white/70 text-sm">Requested by: {{ $b->user->name }} ({{ $b->user->email }})</div>

        <div class="mt-3 flex gap-2">
          <form method="POST" action="{{ route('approvals.approve', $b) }}">
            @csrf
            <input name="decision_note" placeholder="Note (optional)"
              class="bg-white/10 border border-white/10 rounded px-3 py-2 text-sm mr-2">
            <button class="px-4 py-2 rounded bg-indigo-500 hover:bg-indigo-600">Approve</button>
          </form>

          <form method="POST" action="{{ route('approvals.reject', $b) }}">
            @csrf
            <input name="decision_note" required placeholder="Reject reason (required)"
              class="bg-white/10 border border-white/10 rounded px-3 py-2 text-sm mr-2">
            <button class="px-4 py-2 rounded bg-red-500 hover:bg-red-600">Reject</button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-white/60">No pending bookings.</p>
    @endforelse
  </div>
</body>
</html>