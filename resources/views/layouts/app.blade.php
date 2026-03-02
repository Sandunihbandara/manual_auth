<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'AcademiCore')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">

  {{-- Top Navbar --}}
  <nav class="sticky top-0 z-50 bg-black/30 backdrop-blur-xl border-b border-white/10">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

      {{-- Brand --}}
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        {{-- Replace src with your logo path --}}
        <img src="{{ asset('images/unilogo.png') }}" class="w-9 h-9 rounded-xl object-contain" alt="Logo">
        <div>
          <div class="text-lg font-bold leading-5">AcademiCore</div>
          <div class="text-xs text-white/60 -mt-0.5">Instrument Allocation System</div>
        </div>
      </a>

      {{-- Right side --}}
      <div class="flex items-center gap-3">

        @auth
          <div class="hidden sm:block text-right">
            <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
            <div class="text-xs text-white/60">
              {{ auth()->user()->role }}
              @if(auth()->user()->department) • {{ auth()->user()->department }} @endif
            </div>
          </div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 transition text-sm font-semibold">
              Logout
            </button>
          </form>
        @else
          <a href="{{ route('login.show') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 transition text-sm font-semibold">
            Login
          </a>
          <a href="{{ route('register.show') }}" class="px-4 py-2 rounded-xl bg-indigo-500 hover:bg-indigo-600 transition text-sm font-semibold">
            Register
          </a>
        @endauth

      </div>
    </div>

    
  </nav>

  {{-- Page container --}}
  <main class="max-w-6xl mx-auto px-6 py-8">
    {{-- flash message --}}
    @if(session('success'))
      <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 p-4 text-green-200">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

</body>
</html>