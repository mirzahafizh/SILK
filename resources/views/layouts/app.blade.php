
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SILK - Sistem Informasi Kinerja PJLP')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-poltekba.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-poltekba.png') }}">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
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
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800">

    {{-- HEADER --}}
    <header class="bg-poltekba text-white shadow-lg shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

            {{-- Logo dan Identitas SILK --}}
            <a href="{{ route('dashboard.pjlp') }}" class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5 shrink-0">
                    <img src="{{ asset('images/logo-poltekba.png') }}"
                        alt="Logo Politeknik Negeri Balikpapan"
                        class="w-full h-full object-contain">
                </div>

                <div>
                    <h1 class="font-extrabold text-xl tracking-wide">SILK</h1>
                    <p class="text-xs text-blue-100">
                        Sistem Informasi Kinerja PJLP
                    </p>
                </div>

            </a>

            {{-- Informasi Pengguna dan Logout --}}
            <div class="flex items-center gap-3">

                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-blue-100">
                        Pegawai PJLP
                    </p>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="rounded-lg bg-white/10 hover:bg-white/20 px-3 py-2 text-sm font-semibold transition">

                        <i class="fa-solid fa-right-from-bracket mr-1"></i>
                        Keluar

                    </button>
                </form>

            </div>
        </div>
    </header>

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-slate-200 shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex gap-2 overflow-x-auto">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard.pjlp') }}"
                class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2 transition
                {{ request()->routeIs('dashboard.pjlp')
                    ? 'border-poltekba text-poltekba'
                    : 'border-transparent text-slate-500 hover:text-poltekba' }}">

                <i class="fa-solid fa-house mr-1"></i>
                Dashboard

            </a>

            {{-- Riwayat Laporan --}}
            <a href="{{ route('laporan.index') }}"
                class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2 transition
                {{ request()->routeIs('laporan.index', 'laporan.bulan', 'laporan.show', 'laporan.edit')
                    ? 'border-poltekba text-poltekba'
                    : 'border-transparent text-slate-500 hover:text-poltekba' }}">

                <i class="fa-solid fa-file-lines mr-1"></i>
                Riwayat Laporan

            </a>

            {{-- Buat Laporan --}}
            <a href="{{ route('laporan.create') }}"
                class="whitespace-nowrap px-4 py-3 text-sm font-semibold border-b-2 transition
                {{ request()->routeIs('laporan.create')
                    ? 'border-poltekba text-poltekba'
                    : 'border-transparent text-slate-500 hover:text-poltekba' }}">

                <i class="fa-solid fa-plus mr-1"></i>
                Buat Laporan

            </a>

        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 flex-1">

        {{-- Notifikasi Berhasil --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if(session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Validasi Error --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                <p class="font-bold mb-2">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Terdapat kesalahan:
                </p>

                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- Konten Halaman --}}
        @yield('content')

    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white mt-auto shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 text-center text-xs text-slate-500">

            <p>
                &copy; {{ date('Y') }}
                <span class="font-semibold text-poltekba">SILK</span>
                - Sistem Informasi Kinerja PJLP.
            </p>

            <p class="mt-1">
                Politeknik Negeri Balikpapan.
            </p>

        </div>
    </footer>

    {{-- Scripts --}}
    @stack('scripts')

</body>
</html>
