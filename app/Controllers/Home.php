<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Kalau akses ke root "/", langsung tampil landing page
        return view('landing');
    }

    public function landing()
    {
        // Alias (kalau nanti mau dipanggil lewat route lain, misal /landing)
        return view('landing');
    }
}
