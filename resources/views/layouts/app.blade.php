
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SILK - Sistem Informasi Kinerja PJLP')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        poltekba: '#013880',
                        'poltekba-dark': '#00275c'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-poltekba text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

        <a href="{{ route('dashboard.pjlp') }}" class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center">
                <i class="fa-solid fa-clipboard-check text-xl"></i>
            </div>

            <div>
                <h1 class="font-extrabold text-xl tracking-wide">SILK</h1>
                <p class="text-xs text-blue-100">Sistem Informasi Kinerja PJLP</p>
            </div>
        </a>

        <div class="flex items-center gap-3">
            <div class="hidden sm:block text-right">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-100">Pegawai PJLP</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="rounded-lg bg-white/10 hover:bg-white/20 px-3 py-2 text-sm font-semibold">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<nav class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex gap-2 overflow-x-auto">

        <a href="{{ route('dashboard.pjlp') }}"
            class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2
            {{ request()->routeIs('dashboard.pjlp') ? 'border-poltekba text-poltekba' : 'border-transparent text-slate-500 hover:text-poltekba' }}">
            <i class="fa-solid fa-house mr-1"></i>
            Dashboard
        </a>

        <a href="{{ route('laporan.index') }}"
            class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2
            {{ request()->routeIs('laporan.index', 'laporan.bulan', 'laporan.show') ? 'border-poltekba text-poltekba' : 'border-transparent text-slate-500 hover:text-poltekba' }}">
            <i class="fa-solid fa-file-lines mr-1"></i>
            Riwayat Laporan
        </a>

        <a href="{{ route('laporan.create') }}"
            class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2
            {{ request()->routeIs('laporan.create') ? 'border-poltekba text-poltekba' : 'border-transparent text-slate-500 hover:text-poltekba' }}">
            <i class="fa-solid fa-plus mr-1"></i>
            Buat Laporan
        </a>

    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-bold mb-2">Terdapat kesalahan:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</main>

<footer class="border-t border-slate-200 bg-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} SILK - Sistem Informasi Kinerja PJLP.
        Politeknik Negeri Balikpapan.
    </div>
</footer>

@stack('scripts')

</body>
</html>
