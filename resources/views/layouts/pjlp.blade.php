<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','SILK - Sistem Informasi Kinerja PJLP')</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script>tailwind.config={theme:{extend:{colors:{poltekba:'#013880'}}}}</script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<header class="bg-[#013880] text-white shadow">
 <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
  <a href="{{ auth()->user()?->role==='admin' ? route('admin.dashboard') : route('dashboard.pjlp') }}" class="font-bold tracking-wide">SILK <span class="font-normal text-blue-200">| Sistem Informasi Kinerja PJLP</span></a>
  <div class="flex items-center gap-4 text-sm"><span>{{ auth()->user()->name ?? '' }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-lg bg-white/10 px-3 py-2 hover:bg-white/20">Keluar</button></form></div>
 </div>
</header>
<nav class="border-b bg-white"><div class="mx-auto flex max-w-7xl flex-wrap gap-5 px-4 py-3 text-sm font-medium">
@if(auth()->user()?->role==='admin')
<a href="{{ route('admin.dashboard') }}">Dashboard</a><a href="{{ route('admin.karyawan.index') }}">Data Pegawai</a>
@else
<a href="{{ route('dashboard.pjlp') }}">Dashboard</a><a href="{{ route('laporan.index') }}">Riwayat Laporan</a><a href="{{ route('laporan.create') }}">Buat Laporan</a>
@endif
</div></nav>
<main class="mx-auto max-w-7xl px-4 py-8">@yield('content')</main>
<footer class="mt-12 border-t bg-white py-5 text-center text-xs text-slate-500">SILK — Sistem Informasi Kinerja PJLP</footer>
</body></html>
