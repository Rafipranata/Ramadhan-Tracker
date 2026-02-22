<?php

namespace App\Http\Controllers;


use App;

class RamadhanController extends Controller
{
    // Menampilkan halaman utama
    public function index()
    {
        return view('ramadhan.index');
    }

    public function dzikir() {
        return view('ramadhan.dzikir'); 
        
    }

    public function profile() {
        return view('ramadhan.profile');
    }

    // Mengubah bahasa
    public function changeLanguage($lang)
    {
        // Pastikan hanya bahasa yang valid yang diterima
        if (in_array($lang, ['id', 'en'])) {
            session(['locale' => $lang]);  // Menyimpan bahasa yang dipilih ke session
            App::setLocale($lang);         // Mengatur locale Laravel
        }

        return redirect()->back();
    }
}