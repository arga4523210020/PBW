<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Judul halaman dinamis (dari langkah kita sebelumnya) --}}
    <title>{{ $title ?? 'Portal Berita Sederhana' }}</title>

    @vite('resources/css/app.css')

    {{-- Tambahkan script helper untuk Alpine.js (opsional namun sangat berguna untuk nanti) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

{{--
  Kita ubah latar belakang utama menjadi abu-abu sangat muda.
  Konten utama (berita) nanti akan kita letakkan di atas 'lembaran' putih.
--}}
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    {{--
      HEADER BARU (Gaya CNN)
      Kita bagi menjadi 2 bagian: Top Bar dan Main Nav
    --}}
    <header class="bg-white shadow-lg sticky top-0 z-50">

        {{-- 1. TOP BAR (Untuk Tanggal & Login) --}}
        <div class="bg-blue-800 text-white p-2">
            <div class="container mx-auto flex justify-between items-center text-xs">

                {{-- Bagian Kiri: Tanggal Hari Ini (Dibutuhkan sedikit JS) --}}
                <div>
                    <span id="current-date"></span>
                </div>

                {{-- Bagian Kanan: Tombol Login/Dashboard (Fungsionalitas Anda yang sudah ada) --}}
                <div>
                    @guest
                        <a href="{{ url('/admin') }}" class="font-medium hover:text-gray-300 transition-colors">
                            Login Admin
                        </a>
                    @endguest
                    @auth
                        <a href="{{ url('/admin') }}" class="font-medium hover:text-gray-300 transition-colors">
                            Dashboard Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- 2. MAIN NAV (Logo, Kategori & Pencarian) --}}
        <nav class="p-4">
            <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">

                {{-- Logo Anda --}}
                <a href="{{ route('news.index') }}" class="text-3xl font-extrabold text-blue-700 tracking-tight">
                    PORTAL BERITA
                </a>

                {{-- Placeholder untuk Form Pencarian --}}
                <div class="mt-4 md:mt-0">
                    <form action="#" method="GET">
                        <input type="text" placeholder="Cari berita..." class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-700 text-white px-4 py-1.5 rounded-lg ml-1 hover:bg-blue-800">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- 3. CATEGORY NAV (Navigasi Kategori) --}}
        <div class="bg-blue-700 text-white">
            <div class="container mx-auto">
                {{--
                  Ini adalah placeholder. Nanti ini bisa diisi dari database.
                  'font-semibold' memberi tampilan khas navigasi berita.
                --}}
                <ul class="flex space-x-6 p-3 px-4 overflow-x-auto">
                    <li><a href="{{ route('news.index') }}" class="py-1 border-b-2 border-white font-semibold">Home</a></li>
                </ul>
            </div>
        </div>

    </header>

    {{-- KONTEN UTAMA --}}
    {{-- 'flex-grow' akan mendorong footer ke bawah --}}
    <main class_name="container mx-auto px-4 mt-6 mb-8 flex-grow">
        @yield('container')
    </main>

    {{-- FOOTER BARU (Gaya CNN Multi-kolom) --}}
    <footer class="bg-blue-900 text-gray-300 pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">

                {{-- Kolom 1: Kategori --}}
                <div>
                    <h5 class="font-bold text-lg text-white mb-3">Kategori</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Nasional</a></li>
                        <li><a href="#" class="hover:text-white">Internasional</a></li>
                        <li><a href="#" class="hover:text-white">Ekonomi</a></li>
                        <li><a href="#" class="hover:text-white">Olahraga</a></li>
                        <li><a href="#" class="hover:text-white">Teknologi</a></li>
                    </ul>
                </div>

                {{-- Kolom 2: Tentang Kami --}}
                <div>
                    <h5 class="font-bold text-lg text-white mb-3">Tentang</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Tim Redaksi</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                        <li><a href="#" class="hover:text-white">Pedoman Media</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Legal --}}
                <div>
                    <h5 class="font-bold text-lg text-white mb-3">Legal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                {{-- Kolom 4: Ikuti Kami --}}
                <div>
                    <h5 class="font-bold text-lg text-white mb-3">Ikuti Kami</h5>
                    <div class="flex space-x-4">
                        {{-- Placeholder Ikon SVG --}}
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562V12h2.773l-.443 2.89h-2.33V21.878A10.003 10.003 0 0022 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.242 12.303a.75.75 0 10-.001-1.501.75.75 0 00.001 1.501zM11.25 10.5a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm-2.502.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12 16.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" clip-rule="evenodd" /><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 4a8 8 0 100 16 8 8 0 000-16zm0 13a5 5 0 110-10 5 5 0 010 10z" /></svg>
                        </a>
                    </div>
                </div>

            </div>

            {{-- Garis Pemisah --}}
            <div class="border-t border-blue-800 pt-6 text-sm text-center">
                <p>&copy; {{ date('Y') }} Portal Berita. Dibuat dengan Laravel & Filament.</p>
            </div>
        </div>
    </footer>


    {{-- Script Sederhana untuk Menampilkan Tanggal di Top Bar --}}
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const dateElement = document.getElementById('current-date');
            if (dateElement) {
                const today = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateElement.textContent = today.toLocaleDateString('id-ID', options);
            }
        });
    </script>
</body>
</html>
