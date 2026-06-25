<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Menampilkan halaman utama admin
        return view('admin/dashboard');
    }
}