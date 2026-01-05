<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use Illuminate\Http\Request; // Import kelas Request dari Laravel

class PageController extends Controller // Definisikan PageController yang extends Controller dasar
{
    public function home() // Metode untuk menampilkan halaman home
    {
        return view('home'); // Return view halaman home
    }

    public function pricing() // Metode untuk menampilkan halaman pricing
    {
        return view('pages.pricing'); // Return view halaman pricing
    }

    public function help() // Metode untuk menampilkan halaman bantuan
    {
        return view('pages.help'); // Return view halaman bantuan
    }

    public function about() // Metode untuk menampilkan halaman about
    {
        return view('pages.about'); // Return view halaman about
    }

    public function docs() // Metode untuk menampilkan halaman dokumentasi
    {
        return view('pages.docs'); // Return view halaman dokumentasi
    }
}