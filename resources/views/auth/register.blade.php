<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  {{-- Tailwind CDN (quick styling without installing anything) --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-cover bg-center bg-no-repeat"
      style="background-image: url('{{ asset('images/university.jpeg') }}');">

  <!-- Navbar -->
  <nav class="absolute top-0 left-0 w-full px-8 py-4 flex justify-between items-center bg-black/70 backdrop-blur-md border-b border-white/10">

    <!-- Logo + Project Name -->
    <div class="flex items-center gap-3 text-white text-xl font-bold">

        <!-- University Logo Image -->
        <img src="{{ asset('images/unilogo.png') }}" 
             alt="University Logo"
             class="w-10 h-10 object-contain">

        AcademiCore
    </div>

    <!-- Navigation Links -->
    <div class="flex gap-6 text-white/80 font-medium">
        <a href="{{ route('login.show') }}" class="hover:text-indigo-400 transition">
            Login
        </a>
        <a href="{{ route('register.show') }}" class="hover:text-indigo-400 transition">
            Register
        </a>
    </div>

  </nav>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <div class="flex items-center gap-2 mt-6 mb-3 text-indigo-400 font-semibold">
    <!-- Icon -->
    <svg class="w-5 h-5" ...>...</svg>

    
</div>
 


  <div class="relative w-full max-w-md bg-black/60 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8 text-white">
    <h1 class="text-3xl font-bold">Create your account</h1>
    <p class="text-white/70 mt-1">Register to continue.</p>

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

    <form method="POST" action="{{ route('register.perform') }}" class="mt-6 space-y-4">
      @csrf
      
      <!-- Personal Information -->
      <div class="flex items-center gap-2 mt-6 mb-3 text-white text-lg font-semibold">
      <!-- User Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" 
         fill="none" viewBox="0 0 24 24" 
         stroke-width="1.5" stroke="currentColor" 
         class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
      </svg>
      Personal Information
      </div>
      <div>
        <label class="text-sm text-white/80">Name</label>
        <input
          name="name"
          value="{{ old('name') }}"
          placeholder="Your name"
          class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>
      <div>
      <label class="text-sm text-white/80">Contact Number</label>
      <input
        name="phone"
        value="{{ old('phone') }}"
        placeholder="+94 7X XXX XXXX"
        class="mt-1 w-full rounded-xl bg-white/10 border border-white/20 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>
      <hr>

      <!-- University Information -->
      <br>
      <div class="flex items-center gap-2 mt-6 mb-3 text-white text-lg font-semibold">
      <!-- Graduation Cap Icon -->
      <svg xmlns="http://www.w3.org/2000/svg"
         fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor"
         class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 3L2.25 9l9.75 6 9.75-6L12 3z"/>
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M6.75 12v3.75c0 1.242 2.798 2.25 5.25 2.25s5.25-1.008 5.25-2.25V12"/>
    </svg>
    University Information
</div>

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
      <label class="text-sm text-white/80">Role</label>
      <select
        name="role"
        class="mt-1 w-full rounded-xl bg-white/10 border border-white/20 px-4 py-3 text-white outline-none focus:ring-2 focus:ring-indigo-400"
      >
      <option value="" class="bg-slate-900">Select role</option>
      <option value="user"  class="bg-slate-900" {{ old('role')=='user' ? 'selected' : '' }}>User</option>
      <option value="staff" class="bg-slate-900" {{ old('role')=='staff' ? 'selected' : '' }}>Staff</option>
      </select>
      </div>

      <div>
      <label class="text-sm text-white/80">Department</label>
      <select
        name="department"
        class="mt-1 w-full rounded-xl bg-white/10 border border-white/20 px-4 py-3 text-white outline-none focus:ring-2 focus:ring-indigo-400"
          >
        <option value="" class="bg-slate-900">Select department</option>
        @foreach (['ICT','IAT','ET','AT'] as $dept)
        <option value="{{ $dept }}" class="bg-slate-900" {{ old('department')==$dept ? 'selected' : '' }}>
        {{ $dept }}
        </option>
        @endforeach
      </select>
      </div>
      <hr>

      <br>
      <!-- Security -->
      <div class="flex items-center gap-2 mt-6 mb-3 text-white text-lg font-semibold">
    <!-- Lock Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor"
         class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5M5.25 10.5h13.5v9H5.25v-9z"/>
    </svg>
    Security
</div>

      <div>
        <label class="text-sm text-white/80">Password</label>
        <input
          type="password"
          name="password"
          placeholder="Minimum 8 characters"
          class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>

      <div>
        <label class="text-sm text-white/80">Confirm password</label>
        <input
          type="password"
          name="password_confirmation"
          placeholder="Re-enter password"
          class="mt-1 w-full rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:ring-2 focus:ring-indigo-400"
        >
      </div>
      <hr>
      <br><br>

      <button
        type="submit"
        class="w-full rounded-xl bg-indigo-500 hover:bg-indigo-600 transition font-semibold py-3"
      >
        Create account
      </button>
    </form>

    <p class="mt-6 text-sm text-white/70">
      Already have an account?
      <a href="{{ route('login.show') }}" class="text-indigo-300 hover:text-indigo-200 font-semibold">
        Login here
      </a>
    </p>
  </div>

</body>
</html>