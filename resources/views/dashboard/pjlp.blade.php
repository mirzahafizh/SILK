
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard PJLP - SILK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        poltekba: '#013880',
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

<div class="min-h-screen">

    <!-- Overlay untuk tampilan mobile -->
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full
                  flex-col border-r border-slate-200 bg-white
                  transition-transform duration-300 lg:translate-x-0">

        <!-- Logo -->
        <div class="flex h-20 items-center justify-between border-b
                    border-slate-100 px-6">
            <a href="{{ route('dashboard.pjlp') }}"
               class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center
                            rounded-xl bg-poltekba text-lg font-bold text-white">
                    S
                </div>
                <div>
                    <h1 class="text-lg font-bold text-poltekba">SILK</h1>
                    <p class="text-xs text-slate-500">Sistem Informasi PJLP</p>
                </div>
            </a>

            <button onclick="toggleSidebar()"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden"
                    aria-label="Tutup sidebar">
                ✕
            </button>
        </div>

        <!-- Profil singkat -->
        <div class="mx-4 mt-6 rounded-2xl bg-blue-50 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center
                            rounded-full bg-poltekba font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="mt-1 text-xs text-poltekba">Pegawai PJLP</p>
                </div>
            </div>
        </div>

        <!-- Navigasi -->
        <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-6">

            <p class="mb-3 px-3 text-xs font-semibold uppercase
                      tracking-wider text-slate-400">
                Menu Utama
            </p>

            <a href="{{ route('dashboard.pjlp') }}"
               class="flex items-center gap-3 rounded-xl bg-blue-50
                      px-4 py-3 text-sm font-semibold text-poltekba">
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M3 10.5 12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('laporan.create') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3
                      text-sm font-medium text-slate-600
                      hover:bg-slate-100 hover:text-poltekba">
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M12 5v14m-7-7h14"/>
                </svg>
                Input Laporan Harian
            </a>

            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3
                      text-sm font-medium text-slate-600
                      hover:bg-slate-100 hover:text-poltekba">
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                </svg>
                Riwayat Laporan
            </a>

            <div class="!mt-8">
                <p class="mb-3 px-3 text-xs font-semibold uppercase
                          tracking-wider text-slate-400">
                    Akun
                </p>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3
                          text-sm font-medium text-slate-600
                          hover:bg-slate-100 hover:text-poltekba">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M20 21a8 8 0 0 0-16 0m8-10a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                    </svg>
                    Profil Saya
                </a>
            </div>
        </nav>

        <!-- Logout -->
        <div class="border-t border-slate-100 p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl
                               px-4 py-3 text-sm font-semibold text-red-600
                               hover:bg-red-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                    </svg>
                    Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten utama -->
    <div class="min-h-screen lg:pl-72">

        <!-- Header -->
        <header class="sticky top-0 z-30 flex h-20 items-center
                       justify-between border-b border-slate-200
                       bg-white/95 px-4 backdrop-blur sm:px-8">

            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()"
                        class="rounded-xl border border-slate-200 p-2.5
                               hover:bg-slate-100 lg:hidden"
                        aria-label="Buka sidebar">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div>
                    <h2 class="font-bold text-slate-900">Dashboard</h2>
                    <p class="hidden text-xs text-slate-500 sm:block">
                        Sistem Informasi Pelaporan Kinerja PJLP
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-slate-500">Pegawai PJLP</p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center
                            rounded-full bg-poltekba font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-8">

            <!-- Sambutan -->
            <div class="mb-8">
                <p class="text-sm font-medium text-poltekba">
                    Sistem Informasi Kinerja PJLP
                </p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight
                           text-slate-900 sm:text-3xl">
                    Selamat datang, {{ auth()->user()->name }}!
                </h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Pantau dan kelola laporan pekerjaan harian Anda melalui
                    dashboard ini.
                </p>
            </div>

            <!-- Banner -->
            <div class="relative overflow-hidden rounded-2xl
                        bg-poltekba p-6 text-white sm:p-8">
                <div class="relative z-10 max-w-2xl">
                    <span class="rounded-full bg-white/15 px-3 py-1
                                 text-xs font-medium">
                        Portal Pegawai PJLP
                    </span>
                    <h2 class="mt-4 text-xl font-bold sm:text-2xl">
                        Catat pekerjaan Anda setiap hari
                    </h2>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100">
                        Isi laporan pekerjaan secara rutin agar aktivitas
                        harian dapat diperiksa dan direkap oleh verifikator.
                    </p>
                    <a href="{{ route('laporan.create') }}"
                       class="mt-5 inline-flex items-center gap-2 rounded-xl
                              bg-white px-5 py-3 text-sm font-bold
                              text-poltekba hover:bg-blue-50">
                        + Buat Laporan Harian
                    </a>
                </div>

                <div class="pointer-events-none absolute -right-10 -top-16
                            h-64 w-64 rounded-full border-[35px]
                            border-white/10"></div>
                <div class="pointer-events-none absolute -bottom-28
                            right-28 h-48 w-48 rounded-full bg-white/5"></div>
            </div>

            <!-- Ringkasan laporan -->
            <div class="mt-8">
                <h2 class="text-lg font-bold text-slate-900">
                    Ringkasan Laporan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau status laporan pekerjaan Anda.
                </p>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2
                            xl:grid-cols-3">

                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Total Laporan
                            </p>
                            <div class="rounded-xl bg-blue-50 p-3 text-poltekba">
                                <svg class="h-5 w-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-slate-900">—</p>
                        <p class="mt-1 text-xs text-slate-400">
                            Jumlah laporan yang telah dibuat
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Menunggu Verifikasi
                            </p>
                            <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                                <svg class="h-5 w-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9"
                                            stroke-width="1.8"/>
                                    <path stroke-linecap="round"
                                          stroke-width="1.8"
                                          d="M12 7v5l3 2"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-slate-900">—</p>
                        <p class="mt-1 text-xs text-slate-400">
                            Laporan yang belum diperiksa
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Laporan Disetujui
                            </p>
                            <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                                <svg class="h-5 w-5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m5 12 4 4L19 6"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-3xl font-bold text-slate-900">—</p>
                        <p class="mt-1 text-xs text-slate-400">
                            Laporan yang telah disetujui
                        </p>
                    </div>
                </div>
            </div>

            <!-- Aktivitas -->
            <div class="mt-8 rounded-2xl border border-slate-200
                        bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-3 sm:flex-row
                            sm:items-center">
                    <div>
                        <h2 class="font-bold text-slate-900">
                            Aktivitas Laporan
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Lihat dan kelola laporan pekerjaan Anda.
                        </p>
                    </div>

                    <a href="{{ route('laporan.index') }}"
                       class="text-sm font-semibold text-poltekba
                              hover:underline">
                        Lihat semua laporan →
                    </a>
                </div>

                <div class="mt-6 rounded-xl border border-dashed
                            border-slate-300 px-5 py-10 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center
                                justify-center rounded-full bg-slate-100">
                        <svg class="h-6 w-6 text-slate-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                        </svg>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-slate-700">
                        Belum ada data laporan yang ditampilkan
                    </p>
                    <p class="mt-1 text-sm text-slate-500">
                        Data laporan akan muncul setelah modul laporan
                        harian terhubung ke database.
                    </p>
                    <a href="{{ route('laporan.create') }}"
                       class="mt-4 inline-flex rounded-lg bg-poltekba
                              px-4 py-2.5 text-sm font-semibold text-white
                              hover:bg-blue-800">
                        Buat laporan pertama
                    </a>
                </div>
            </div>

            <footer class="mt-10 border-t border-slate-200 py-6
                           text-center text-xs text-slate-400">
                © {{ date('Y') }} SILK — Sistem Informasi Kinerja PJLP
            </footer>
        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>

</body>
</html>
