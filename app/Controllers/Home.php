<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\CategoryModel;
use App\Models\VariantModel;

class Home extends BaseController
{
    // Helper: gabungkan daftar menu dengan varian masing-masing + harga termurah untuk ditampilkan di kartu
    private function attachVariants(array $menus): array
    {
        $variantModel = new VariantModel();
        $allVariants  = $variantModel->orderBy('id', 'ASC')->findAll();

        // Kelompokkan varian berdasarkan menu_id supaya gampang dicocokkan
        $variantsByMenu = [];
        foreach ($allVariants as $v) {
            $variantsByMenu[$v['menu_id']][] = $v;
        }

        foreach ($menus as &$menu) {
            $menu['variants'] = $variantsByMenu[$menu['id']] ?? [];

            if (!empty($menu['variants'])) {
                $menu['price'] = min(array_column($menu['variants'], 'price'));
                $menu['stock'] = array_sum(array_column($menu['variants'], 'stock'));
            } else {
                $menu['price'] = 0;
                $menu['stock'] = 0;
            }
        }
        unset($menu);

        return $menus;
    }

    public function index()
    {
        // Inisialisasi model
        $categoryModel = new CategoryModel();
        $db = \Config\Database::connect();

        // 1. Ambil semua kategori untuk bagian tab filter
        $data['categories'] = $categoryModel->findAll();

        // 2. Ambil menu REKOMENDASI, lalu lengkapi dengan data varian
        $recommendedMenus = $db->table('menus')
            ->where('is_recommended', 1)
            ->where('is_active', 1)
            ->where('status', 'approved') // hanya tampilkan menu yang sudah disetujui owner
            ->get()
            ->getResultArray();
        $data['recommended_menus'] = $this->attachVariants($recommendedMenus);

        // 3. Ambil SEMUA MENU AKTIF, lalu lengkapi dengan data varian
        $allMenus = $db->table('menus')
            ->where('is_active', 1)
            ->where('status', 'approved') // hanya tampilkan menu yang sudah disetujui owner
            ->get()
            ->getResultArray();
        $data['all_menus'] = $this->attachVariants($allMenus);

        // Kirim data ke view pelanggan/beranda
        return view('pelanggan/beranda', $data);
    }

    // Halaman "Lihat semua menu" (dipanggil dari tombol "Lihat semua" di beranda)
    public function menu()
    {
        $categoryModel = new CategoryModel();
        $db = \Config\Database::connect();

        $data['categories'] = $categoryModel->findAll();

        $categoryId = $this->request->getGet('category');

        $builder = $db->table('menus')
            ->where('is_active', 1)
            ->where('status', 'approved');

        if (!empty($categoryId)) {
            $builder->where('category_id', $categoryId);
        }

        $allMenus = $builder->get()->getResultArray();
        $data['all_menus'] = $this->attachVariants($allMenus);

        return view('pelanggan/menu', $data);
    }
}