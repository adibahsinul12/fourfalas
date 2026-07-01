<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;

class Karyawan extends BaseController
{
    public function index()
    {
        $model  = new KaryawanModel();
        $bidang = $this->request->getGet('bidang');

        $query = $model->orderBy('bidang', 'ASC')->orderBy('nama', 'ASC');
        if ($bidang) {
            $query = $query->where('bidang', $bidang);
        }

        $data = [
            'karyawan'     => $query->findAll(),
            'bidang_aktif' => $bidang,
            'bidang_list'  => KaryawanModel::BIDANG_LIST,
        ];

        return view('owner/karyawan', $data);
    }

    /**
     * Toggle status Aktif <-> Nonaktif. Bukan CRUD penuh — sesuai kebutuhan Owner
     * yang hanya perlu memantau & menonaktifkan/mengaktifkan staf.
     */
    public function updateStatus($id)
    {
        $model    = new KaryawanModel();
        $karyawan = $model->find($id);

        if (! $karyawan) {
            session()->setFlashdata('msg', 'Data karyawan tidak ditemukan.');
            return redirect()->to('/owner/karyawan');
        }

        $statusBaru = $karyawan['status'] === 'Aktif' ? 'Nonaktif' : 'Aktif';
        $model->update($id, ['status' => $statusBaru]);

        session()->setFlashdata('msg', "Status {$karyawan['nama']} diubah menjadi {$statusBaru}.");

        // Balik ke filter bidang yang sedang aktif (kalau ada) biar posisi user tidak reset
        $bidang = $this->request->getPost('bidang') ?? $this->request->getGet('bidang');
        return redirect()->to($bidang ? '/owner/karyawan?bidang=' . urlencode($bidang) : '/owner/karyawan');
    }
}