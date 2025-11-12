<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ini method controller untuk landing page news
   public function index()
    {
        // 1. Berita Utama (Hero Section) - 1 Berita
        // Kita ambil 1 berita terbaru sebagai hero.
        $berita_utama = News::with('wartawan')->latest()->first();

        // 2. Berita Pilihan (Grid di bawah Hero) - 4 Berita
        // Kita ambil 4 berita selanjutnya (lewati 1 yang sudah jadi hero)
        $berita_pilihan = News::with('wartawan')->latest()->skip(1)->take(4)->get();

        // 3. Daftar Berita (Feed Utama) - 10 Berita
        // Kita ambil 10 berita selanjutnya (lewati 5 yang sudah tampil)
        $berita_terbaru_list = News::with('wartawan')->latest()->skip(5)->take(10)->get();

        // 4. Title untuk tab browser
        $title = 'Portal Berita Terkini';

        // Kirim semua data ke view
        return view('news.index', [
            'berita_utama' => $berita_utama,
            'berita_pilihan' => $berita_pilihan,
            'berita_terbaru_list' => $berita_terbaru_list,
            'title' => $title
        ]);
    }

    // ini method controller untuk menampilkan detail news
    // $news akan otomatis diisi oleh Laravel berdasarkan id news yang diakses di route
    // News $news artinya Laravel akan melakukan route model binding
    public function show(News $news)
    {
        // load relasi wartawan dan komentar
        $news->load('wartawan', 'komentar');

        // tampilkan view news.show dengan mengirim data news yang sudah di load relasinya
        return view('news.show', [
            'news' => $news
        ]);
    }
}
