@extends('layouts.main')

@section('container')

{{--
  Sama seperti index.blade.php, kita bungkus semua konten
  dalam 'lembar putih' ini agar kontras dengan body abu-abu.
--}}
<div class="bg-white p-6 rounded-lg shadow-lg">

    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- KODE BARU: Wrapper untuk layout Grid 2 Kolom --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-8">

        {{-- KOLOM UTAMA (KIRI) --}}
        <div class="lg:col-span-2">

            {{-- 1. KONTEN ARTIKEL BERITA --}}
            <article class="mb-6">

                {{-- Header Artikel (Judul dan Metadata) --}}
                <header class="mb-6 border-b-2 pb-4">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-3">
                        {{ $news->judul }}
                    </h1>
                    <div class="text-sm text-gray-600">
                        Oleh <a href="#" class="font-semibold text-blue-700">{{ $news->wartawan->nama }}</a>
                        <span class="mx-2">|</span>
                        <span>Diterbitkan: {{ $news->created_at->format('l, d M Y H:i') }} WIB</span>
                    </div>
                </header>

                {{-- Isi Artikel --}}
                {{--
                  Kita tambahkan class 'prose-lg' agar format dari RichEditor
                  (bold, list, dll) tampil indah dan mudah dibaca.
                --}}
                <div class="prose prose-lg max-w-none text-gray-800">
                    {!! $news->isi !!}
                </div>
            </article>

            {{-- Garis Pemisah --}}
            <hr class="my-8">

            {{-- 2. FORMULIR KOMENTAR --}}
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tinggalkan Komentar</h2>

                {{-- Formulir Anda tidak perlu diubah, hanya dipindahkan --}}
                <form action="{{ route('komentar.store', $news->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="isi" class="block text-gray-700 font-semibold mb-2">Isi Komentar</label>
                        <textarea id="isi" name="isi" rows="4"
                                  class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('isi') border-red-500 @enderror" required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition-colors font-medium">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </section>

            {{-- 3. DAFTAR KOMENTAR --}}
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Komentar ({{ $news->komentar->count() }})
                </h2>
                <div class="space-y-6">
                    {{-- Kita urutkan dari yang terbaru menggunakan 'sortByDesc' --}}
                    @forelse ($news->komentar->sortByDesc('created_at') as $comment)
                        <div class="flex space-x-3 border-b pb-4">
                            <div class="flex-shrink-0">
                                {{-- Placeholder avatar, memberi kesan profesional --}}
                                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center font-bold text-gray-600">
                                    {{ substr($comment->nama, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-semibold text-lg">{{ $comment->nama }}</h4>
                                <p class="text-gray-500 text-sm mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                                <p class="text-gray-700">{{ $comment->isi }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada komentar.</p>
                    @endforelse
                </div>
            </section>

        </div> {{-- Akhir Kolom Utama --}}

        {{-- KOLOM SAMPING (KANAN/SIDEBAR) --}}
        <aside class="lg:col-span-1">
            {{-- 'sticky top-28' agar 'mengapung' di bawah header --}}
            <div class="sticky top-28 space-y-6">

                {{-- Card 'Tentang Penulis' (Fitur profesional baru) --}}
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 border-b border-gray-300 pb-2">Tentang Penulis</h3>
                    <h4 class="text-lg font-semibold text-blue-700">{{ $news->wartawan->nama }}</h4>
                    <p class="text-gray-600 text-sm">{{ $news->wartawan->email }}</p>
                    <p class="mt-2 text-sm text-gray-700">
                        Penulis ini adalah bagian dari tim redaksi kami yang berdedikasi menyajikan berita akurat dan terpercaya.
                    </p>
                </div>

                {{-- Card 'Terpopuler' (Placeholder) --}}
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Terpopuler</h3>
                    <div class="space-y-3">
                        <a href="#" class="block font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 1</a>
                        <a href="#" class="block font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 2</a>
                        <a href="#" class="block font-semibold text-gray-800 hover:text-blue-600">Placeholder Berita Terpopuler 3</a>
                    </div>
                </div>

                {{--
                  Kita hapus link "Kembali ke Daftar Berita" yang lama di bagian bawah.
                  Pengguna sekarang bisa menggunakan navigasi header (Logo atau 'Home')
                  untuk kembali, yang jauh lebih standar untuk situs berita.
                --}}

            </div>
        </aside> {{-- Akhir Kolom Samping --}}

    </div> {{-- Akhir Grid Wrapper --}}

</div> {{-- Akhir dari 'lembar putih' --}}
@endsection
