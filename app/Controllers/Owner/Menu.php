<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\MenuVariantModel;
use Config\Database;

class Menu extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        $data = [
            'daftar_menu' => $menuModel->findAll(),
        ];

        return view('owner/menu', $data);
    }

    public function add()
    {
        // ... logic tambah menu + varian
    }

    public function edit($id)
    {
        // ... logic edit menu + varian
    }

    public function delete($id)
    {
        // ... logic hapus menu
    }

    public function approve($id)
    {
        $menuModel = new MenuModel();
        $menuModel->update($id, [
            'status'         => 'approved',
            'rejection_note' => null,
        ]);

        return redirect()->to(base_url('owner/menu'))->with('success', 'Menu disetujui.');
    }

    public function reject($id)
    {
        $menuModel = new MenuModel();
        $menuModel->update($id, [
            'status'         => 'rejected',
            'rejection_note' => $this->request->getPost('note'),
        ]);

        return redirect()->to(base_url('owner/menu'))->with('success', 'Menu ditolak.');
    }
}