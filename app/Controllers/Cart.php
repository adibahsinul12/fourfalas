<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Cart extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    // Menampilkan halaman keranjang belanja
    public function index()
    {
        $data['cart'] = $this->session->get('cart') ?? [];
        
        // Hitung total harga belanjaan sementara
        $data['subtotal'] = 0;
        foreach ($data['cart'] as $item) {
            $data['subtotal'] += $item['price'] * $item['quantity'];
        }

        return view('pelanggan/keranjang', $data);
    }

    // Tombol (+) Tambah kuantitas
    public function add()
    {
        $menuId = $this->request->getPost('menu_id');
        if (!$menuId) return redirect()->back();

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += 1;
        } else {
            $menuModel = new MenuModel();
            $menu = $menuModel->find($menuId);

            if ($menu) {
                $cart[$menuId] = [
                    'id'         => $menu['id'],
                    'menu_name'  => $menu['menu_name'],
                    'price'      => $menu['price'],
                    'image_path' => $menu['image_path'],
                    'quantity'   => 1
                ];
            }
        }

        $this->session->set('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan!');
    }

    // Tombol (-) Kurangi kuantitas
    public function decrease($menuId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            if ($cart[$menuId]['quantity'] > 1) {
                $cart[$menuId]['quantity'] -= 1;
            } else {
                // Jika sisa 1 lalu dikurangi, otomatis hapus dari keranjang
                unset($cart[$menuId]);
            }
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'));
    }

    // Tombol (Hapus) menghilangkan item dari keranjang
    public function remove($menuId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            unset($cart[$menuId]);
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'))->with('success', 'Menu dihapus dari keranjang.');
    }
}