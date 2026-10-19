
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#013880">

    <title>Login | Sistem Informasi PJLP Poltekba</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .login-bg {
            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(59, 130, 246, .22),
                    transparent 32%
                ),
                linear-gradient(135deg, #011b43, #013880 55%, #0759a8);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50">

    <main class="min-h-screen grid lg:grid-cols-2">

        <!-- PANEL INFORMASI -->
        <section class="login-bg relative hidden lg:flex flex-col
                        justify-between overflow-hidden p-12 xl:p-16
                        text-white">

            <div class="absolute -right-24 -bottom-24
                        h-96 w-96 rounded-full border border-white/10">
            </div>

            <div class="absolute -right-12 -bottom-12
                        h-72 w-72 rounded-full border border-white/10">
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center
                            rounded-2xl bg-white text-blue-900 font-bold
                            text-xl shadow-lg">
                    PB
                </div>

                <div>
                    <p class="font-bold tracking-wide">
                        POLITEKNIK NEGERI BALIKPAPAN
                    </p>
                    <p class="text-sm text-blue-100">
                        Sistem Informasi PJLP
                    </p>
                </div>
            </div>

            <div class="relative z-10 max-w-xl">
                <p class="mb-5 inline-flex items-center gap-2 rounded-full
                          border border-white/20 bg-white/10 px-4 py-2
                          text-sm text-blue-100">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Sistem Pelaporan Terintegrasi
                </p>

                <h1 class="text-4xl font-bold leading-tight xl:text-5xl">
                    Pelaporan Harian yang
                    <span class="text-blue-200">Lebih Mudah.</span>
                </h1>

                <p class="mt-6 max-w-lg leading-7 text-blue-100">
                    Kelola laporan pekerjaan harian, pantau status
                    verifikasi, dan dukung administrasi kinerja PJLP
                    secara terstruktur dalam satu sistem.
                </p>

                <div class="mt-10 grid grid-cols-3 gap-4">
                    <div class="rounded-xl border border-white/15
                                bg-white/10 p-4">
                        <p class="text-sm text-blue-200">Akses</p>
                        <p class="mt-1 font-semibold">Fleksibel</p>
                    </div>

                    <div class="rounded-xl border border-white/15
                                bg-white/10 p-4">
                        <p class="text-sm text-blue-200">Laporan</p>
                        <p class="mt-1 font-semibold">Harian</p>
                    </div>

                    <div class="rounded-xl border border-white/15
                                bg-white/10 p-4">
                        <p class="text-sm text-blue-200">Rekap</p>
                        <p class="mt-1 font-semibold">Bulanan</p>
                    </div>
                </div>
            </div>

            <p class="relative z-10 text-sm text-blue-200">
                © {{ date('Y') }} Politeknik Negeri Balikpapan
            </p>
        </section>

        <!-- FORM LOGIN -->
        <section class="flex items-center justify-center px-5 py-10
                        sm:px-10 lg:px-12">

            <div class="w-full max-w-md">

                <!-- Identitas mobile -->
                <div class="mb-10 flex items-center gap-3 lg:hidden">
                    <div class="flex h-12 w-12 items-center justify-center
                                rounded-xl bg-blue-900 font-bold text-white">
                        PB
                    </div>

                    <div>
                        <p class="text-sm font-bold text-slate-900">
                            POLITEKNIK NEGERI BALIKPAPAN
                        </p>
                        <p class="text-xs text-slate-500">
                            Sistem Informasi PJLP
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="mb-5 flex h-14 w-14 items-center
                                justify-center rounded-2xl bg-blue-50
                                text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-7 w-7"
                             fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M4 21v-2a8 8 0 0 1 16 0v2H4Z"/>
                        </svg>
                    </div>

                    <h2 class="text-3xl font-bold tracking-tight
                               text-slate-900">
                        Selamat datang
                    </h2>

                    <p class="mt-2 leading-6 text-slate-500">
                        Masuk ke akun Anda untuk mengakses
                        sistem pelaporan PJLP.
                    </p>
                </div>

                @if ($errors->any())
                    <div role="alert"
                         class="mb-5 rounded-xl border border-red-200
                                bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-green-200
                                bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login.process') }}"
                      method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nip"
                               class="mb-2 block text-sm font-semibold
                                      text-slate-700">
                            NIP / Nomor Identitas
                        </label>

                        <input
                            type="text"
                            name="nip"
                            id="nip"
                            value="{{ old('nip') }}"
                            placeholder="Masukkan NIP Anda"
                            autocomplete="username"
                            required
                            autofocus
                            class="w-full rounded-xl border border-slate-200
                                   bg-white px-4 py-3.5 text-sm
                                   outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-blue-700
                                   focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password"
                                   class="block text-sm font-semibold
                                          text-slate-700">
                                Password
                            </label>
                        </div>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-xl border
                                       border-slate-200 bg-white
                                       px-4 py-3.5 pr-12 text-sm
                                       outline-none transition
                                       placeholder:text-slate-400
                                       focus:border-blue-700
                                       focus:ring-4 focus:ring-blue-100"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                                class="absolute inset-y-0 right-0
                                       flex items-center px-4
                                       text-slate-400
                                       hover:text-blue-800"
                            >
                                <svg id="eyeIcon"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M2.5 12s3.5-7 9.5-7
                                             9.5 7 9.5 7-3.5 7-9.5 7
                                             -9.5-7-9.5-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center
                               gap-2 rounded-xl bg-blue-900 px-4 py-3.5
                               font-semibold text-white shadow-lg
                               shadow-blue-900/15 transition
                               hover:bg-blue-800
                               focus:outline-none focus:ring-4
                               focus:ring-blue-200"
                    >
                        Masuk ke Sistem

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 7l5 5m0 0-5 5m5-5H4"/>
                        </svg>
                    </button>
                </form>

                <div class="my-8 border-t border-slate-200"></div>

                <div class="flex items-start gap-3 rounded-xl
                            bg-slate-100 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mt-0.5 h-5 w-5 shrink-0 text-slate-500"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3 4 6v5c0 5 3.5 8 8 10
                                 4.5-2 8-5 8-10V6l-8-3Z"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m9 12 2 2 4-4"/>
                    </svg>

                    <p class="text-xs leading-5 text-slate-600">
                        Gunakan akun resmi yang diberikan oleh
                        administrator. Jaga kerahasiaan password
                        Anda dan selalu logout setelah selesai.
                    </p>
                </div>

                <p class="mt-8 text-center text-xs text-slate-400">
                    © {{ date('Y') }} Sistem Informasi PJLP Poltekba
                </p>
            </div>
        </section>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';

            togglePassword.setAttribute(
                'aria-pressed',
                String(isHidden)
            );

            togglePassword.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    </script>
</body>
</html>
