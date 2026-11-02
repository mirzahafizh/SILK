
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - SILK</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden grid md:grid-cols-2">

    <div class="hidden md:flex flex-col justify-between bg-[#013880] text-white p-10">
        <div>
            <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center mb-8">
                <i class="fa-solid fa-clipboard-check text-2xl"></i>
            </div>

            <p class="text-sm font-semibold text-blue-200 tracking-widest uppercase">
                Politeknik Negeri Balikpapan
            </p>

            <h1 class="text-4xl font-extrabold leading-tight mt-4">
                Sistem Informasi Kinerja PJLP
            </h1>

            <p class="mt-5 text-blue-100 leading-relaxed">
                Platform digital untuk pencatatan, pelaporan, dan pemantauan aktivitas kerja harian pegawai PJLP.
            </p>
        </div>

        <div class="text-sm text-blue-200">
            &copy; {{ date('Y') }} SILK
        </div>
    </div>

    <div class="p-7 sm:p-10 md:p-12 flex flex-col justify-center">

        <div class="mb-8">
            <div class="md:hidden w-12 h-12 rounded-xl bg-[#013880] text-white flex items-center justify-center mb-5">
                <i class="fa-solid fa-clipboard-check text-xl"></i>
            </div>

            <p class="text-sm font-bold text-[#013880]">SELAMAT DATANG</p>
            <h2 class="text-3xl font-extrabold text-slate-800 mt-2">Masuk ke SILK</h2>
            <p class="text-sm text-slate-500 mt-2">
                Masukkan NIP dan kata sandi untuk melanjutkan.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nip" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nomor Induk Pegawai (NIP)
                </label>

                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <input id="nip" type="text" name="nip"
                        value="{{ old('nip') }}"
                        required autofocus autocomplete="username"
                        placeholder="Masukkan NIP"
                        class="w-full rounded-xl border border-slate-300 pl-11 pr-4 py-3 outline-none focus:border-[#013880] focus:ring-2 focus:ring-blue-100">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Kata Sandi
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <input id="password" type="password" name="password"
                        required autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                        class="w-full rounded-xl border border-slate-300 pl-11 pr-12 py-3 outline-none focus:border-[#013880] focus:ring-2 focus:ring-blue-100">

                    <button type="button" id="togglePassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" value="1"
                    class="rounded border-slate-300 text-[#013880] focus:ring-[#013880]">

                <label for="remember" class="ml-2 text-sm text-slate-600">
                    Ingat saya
                </label>
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-[#013880] hover:bg-[#00275c] text-white font-bold py-3.5 transition shadow-lg">
                Masuk <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-8">
            Sistem Informasi Kinerja PJLP &bull; Politeknik Negeri Balikpapan
        </p>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');

        input.type = input.type === 'password' ? 'text' : 'password';

        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
