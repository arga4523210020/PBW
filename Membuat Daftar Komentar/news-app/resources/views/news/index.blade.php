@extends('layouts.main')

@section('container')

{{--
  Ini adalah "lembar putih" tempat kita menaruh konten.
  Body di layout utama berwarna abu-abu, jadi kita buat kontras di sini.
--}}
<div class="bg-white p-6 rounded-lg shadow-lg">

    {{-- 1. HERO SECTION (BERITA UTAMA) --}}
    @if ($berita_utama)
        <section class="mb-6 border-b-4 border-blue-700 pb-6">
            {{-- Tampilan di layar besar (Desktop) --}}
            <div class="hidden md:block">
                <a href="{{ route('news.show', $berita_utama->id) }}" class="group">
                    {{-- Judul Besar --}}
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">
                        {{ $berita_utama->judul }}
                    </h1>
                </a>
                {{-- Metadata --}}
                <p class="text-gray-600 text-sm mb-3">
                    Oleh <span class="font-semibold">{{ $berita_utama->wartawan->nama }}</span> | {{ $berita_utama->created_at->diffForHumans() }}
                </p>
                {{-- Ringkasan --}}
                <p class="text-gray-700 text-lg">
                    {{ $berita_utama->ringkasan }}
                </p>
            </div>

            {{-- Tampilan di layar kecil (Mobile) - Dibuat lebih ringkas --}}
            <div class="block md:hidden">
                <a href="{{ route('news.show', $berita_utama->id) }}" class="group">
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">
                        {{ $berita_utama->judul }}
                    </h1>
                </a>
                <p class="text-gray-600 text-sm mb-3">
                    Oleh <span class="font-semibold">{{ $berita_utama->wartawan->nama }}</span>
                </p>
                <p class="text-gray-700 text-base">
                    {{ $berita_utama->ringkasan }}
                </p>
            </div>
        </section>
    @endif

    {{-- 2. BERITA PILIHAN (GRID 4 KOLOM) --}}
    @if ($berita_pilihan->count() > 0)
        <section class="mb-6 border-b border-gray-200 pb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Berita Pilihan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($berita_pilihan as $news)
                    <article>
                        <a href="{{ route('news.show', $news->id) }}" class="group">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $news->judul }}
                            </h3>
                        </a>
                        <p class="text-gray-500 text-xs mt-1">
                            {{ $news->created_at->diffForHumans() }}
                        </p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 3. FEED UTAMA (2 KOLOM: BERITA TERBARU & SIDEBAR) --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: DAFTAR BERITA TERBARU --}}
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Berita Terbaru</h2>

            <div class="space-y-6">
                @forelse ($berita_terbaru_list as $news)
                    {{-- Card Berita Horizontal --}}
                    <article class="flex items-start space-x-4 border-b pb-4">
                        {{-- Placeholder untuk gambar jika ada, jika tidak, kita tidak tampilkan --}}
                        {{-- <img src="placeholder.jpg" alt="thumbnail" class="w-32 h-20 object-cover rounded-lg"> --}}

                        <div class="flex-grow">
                            <a href="{{ route('news.show', $news->id) }}" class="group">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $news->judul }}
                                </h3>
                            </a>
                            <p class="text-gray-700 text-sm mt-2 mb-2">
                                {{ Str::limit($news->ringkasan, 120, '...') }}
                            </p>
                            <p class="text-gray-500 text-xs">
                                Oleh <span class="font-medium">{{ $news->wartawan->nama }}</span> | {{ $news->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-500">Belum ada berita terbaru.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: SIDEBAR --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-28"> {{-- 'top-28' agar ada jarak dari header yg sticky --}}
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Terpopuler</h3>

                {{-- Placeholder untuk berita terpopuler --}}
                <div class="space-y-4">
                    <div class="border-b pb-2">
                        <a href="#" class="text-lg font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 1</a>
                    </div>
                    <div class="border-b pb-2">
                        <a href="#" class="text-lg font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 2</a>
                    </div>
                    <div class="border-b pb-2">
                        <a href="#" class="text-lg font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 3</a>
                    </div>
                    <div class="border-b pb-2">
                        <a href="#" class="text-lg font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 4</a>
                    </div>
                </div>

                {{-- Placeholder Iklan --}}
                <div class="mt-8 p-4 bg-gray-200 rounded-lg text-center text-gray-500">
                    Area Iklan
                </div>
            </div>
        </aside>

    </section>

</div> {{-- Akhir dari 'lembar putih' --}}

@endsection
