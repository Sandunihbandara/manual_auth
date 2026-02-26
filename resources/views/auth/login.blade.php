<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  {{-- Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-4">

  <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl p-8 text-white">

    <h1 class="text-3xl font-bold">Welcome back</h1>
    <p class="text-white/70 mt-1">Login to your account.</p>

    {{-- Errors --}}
    @if ($errors->any())
      <div class="mt-4 rounded-xl border border-red-400/40 bg-red-500/10 p-4">
        <ul class="list-disc pl-5 text-sm text-red-200 space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login.perform') }}" class="mt-6 space-y-4">
      @csrf

      <div>
        <label class="text-sm text-white/80">Email</label>
        <input
          name="email"
          value="{{ old('email') }}"
          placeholder="you@example.com"
          class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>

      <div>
        <label class="text-sm text-white/80">Password</label>
        <input
          type="password"
          name="password"
          placeholder="Enter your password"
          class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>

      <div class="flex items-center justify-between text-sm text-white/70">
        <label class="flex items-center gap-2">
          <input type="checkbox" name="remember" value="1" class="accent-indigo-500">
          Remember me
        </label>

        {{-- Optional: Add forgot password later --}}
        <a href="#" class="hover:text-indigo-300 transition">
          Forgot password?
        </a>
      </div>

      <button
        type="submit"
        class="w-full rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold py-3"
      >
        Login
      </button>
    </form>

    <p class="mt-6 text-sm text-white/70">
      Don’t have an account?
      <a href="{{ route('register.show') }}" class="text-indigo-300 hover:text-indigo-200 font-semibold">
        Register here
      </a>
    </p>

  </div>

</body>
</html>