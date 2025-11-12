@extends('layouts.main')

@section('container')

    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <article class="bg-white p-6 rounded-lg shadow-md mb-6">
        {{-- ... (Isi artikel Anda yang sudah ada) ... --}}
        <h1 class="text-3xl font-bold mb-4">{{ $news->judul }}</h1>
        <p class="text-gray-600 mb-2">Oleh {{ $news->wartawan->nama }} | {{ $news->created_at->format('d M Y') }}</p>
        <div class="prose max-w-none">
            {!! $news->isi !!}
        </div>
    </article>

    {{-- KODE BARU: FORMULIR KOMENTAR --}}
    <section class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tinggalkan Komentar</h2>

        <form action="{{ route('komentar.store', $news->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                       class="w-full p-3 border border-gray-300 rounded-lg @error('nama') border-red-500 @enderror" required>

                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="isi" class="block text-gray-700 font-semibold mb-2">Isi Komentar</label>
                <textarea id="isi" name="isi" rows="4"
                          class="w-full p-3 border border-gray-300 rounded-lg @error('isi') border-red-500 @enderror" required>{{ old('isi') }}</textarea>

                @error('isi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Kirim Komentar
                </button>
            </div>
        </form>
    </section>
    {{-- AKHIR KODE BARU --}}


    {{-- Bagian Daftar Komentar (dari langkah sebelumnya) --}}
    <section class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-semibold mb-4">Komentar ({{ $news->komentar->count() }})</h2>
        <div class="space-y-4">
            @forelse ($news->komentar as $comment)
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg">{{ $comment->nama }}</h3>
                    <p class="text-gray-500 text-sm mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                    <p class="text-gray-700">{{ $comment->isi }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>
    </section>

    <a href="{{ route('news.index') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar Berita</a>
@endsection
