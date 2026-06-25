<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $menuModel = new MenuModel();
        $categoryModel = new CategoryModel();

        // 1. Ambil semua kategori untuk bagian tab filter
        $data['categories'] = $categoryModel->findAll();

        // 2. Ambil menu yang diberi tanda rekomendasi (is_recommended = 1) dan berstatus aktif
        $data['recommended_menus'] = $menuModel->where('is_recommended', 1)
                                                ->where('is_active', 1)
                                                ->findAll();

        // 3. Ambil semua menu yang aktif untuk etalase utama
        $data['all_menus'] = $menuModel->where('is_active', 1)->findAll();

        // Kirim data ke view pelanggan/beranda
        return view('pelanggan/beranda', $data);
    }
}