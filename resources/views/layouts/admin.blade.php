
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin SILK')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-poltekba.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-poltekba.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        .sidebar-link.active {
            background: rgba(255,255,255,.14);
            color: white;
        }

            [x-cloak] {
        display: none !important;
    }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-100 min-h-screen">

<div class="min-h-screen flex">

    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-poltekba text-white transform -translate-x-full transition-transform duration-300 lg:translate-x-0 lg:static lg:flex lg:flex-col">

        <div class="px-6 py-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5">
                    <img src="{{ asset('images/logo-poltekba.png') }}"
                        alt="Logo Politeknik Negeri Balikpapan"
                        class="w-full h-full object-contain">
                </div>

                <div>
                    <h1 class="font-extrabold text-xl">SILK</h1>
                    <p class="text-xs text-blue-200">Administrator</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">

            <p class="px-3 mb-3 text-[10px] font-bold tracking-widest uppercase text-blue-200">
                Menu Utama
            </p>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-blue-100 hover:bg-white/10">
                <i class="fa-solid fa-house w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.karyawan.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-blue-100 hover:bg-white/10">
                <i class="fa-solid fa-users w-5"></i>
                Data Karyawan
            </a>

            <div class="pt-6">
                <p class="px-3 mb-3 text-[10px] font-bold tracking-widest uppercase text-blue-200">
                    Akun
                </p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-blue-100 hover:bg-white/10">
                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </nav>

        <div class="p-4 border-t border-white/10">
            <p class="text-xs text-blue-200">Login sebagai</p>
            <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-blue-200">Administrator SILK</p>
        </div>
    </aside>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

    <div class="flex-1 min-w-0 flex flex-col">

        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6">

            <div class="flex items-center gap-3">
                <button id="sidebarToggle" class="lg:hidden text-slate-600 text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>
                    <h2 class="font-bold text-slate-800">@yield('page-heading', 'Dashboard')</h2>
                    <p class="hidden sm:block text-xs text-slate-500">
                        @yield('page-description', 'Sistem Informasi Kinerja PJLP')
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-100 text-poltekba flex items-center justify-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <span class="hidden sm:block text-sm font-semibold text-slate-700">
                    {{ auth()->user()->name }}
                </span>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="px-6 py-4 border-t border-slate-200 bg-white text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} SILK - Politeknik Negeri Balikpapan
        </footer>

    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    toggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>

@stack('scripts')

</body>
</html>
