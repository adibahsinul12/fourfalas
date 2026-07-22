<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\TableModel;

class MejaController extends BaseController
{
    public function index()
    {
        $tableModel = new TableModel();
        $data['meja'] = $tableModel->orderBy('table_number', 'ASC')->findAll();

        return view('owner/meja/index', $data);
    }

    public function simpan()
    {
        $tableModel = new TableModel();

        $inputMeja = $this->request->getPost('table_number');
        $kapasitas = $this->request->getPost('capacity');

        $nomorMejaAngka = preg_replace('/[^0-9]/', '', $inputMeja);
        if (empty($nomorMejaAngka)) {
            $nomorMejaAngka = 0;
        }

        $tableModel->insert([
            'table_number' => $nomorMejaAngka,
            'capacity'     => $kapasitas,
            'type'         => 'Reguler',
            'status'       => 'Tersedia',
        ]);

        return redirect()->to(base_url('owner/meja'))->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function update($id)
    {
        $tableModel = new TableModel();

        $tableModel->update($id, [
            'table_number' => $this->request->getPost('table_number'),
            'capacity'     => $this->request->getPost('capacity'),
            'status'       => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('owner/meja'))->with('success', 'Data meja berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $tableModel = new TableModel();
        $tableModel->delete($id);

        return redirect()->to(base_url('owner/meja'))->with('success', 'Meja berhasil dihapus!');
    }
}