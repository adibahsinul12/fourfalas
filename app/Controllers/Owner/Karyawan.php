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
     * Toggle status Aktif <-> Nonaktif.
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

        $bidang = $this->request->getPost('bidang') ?? $this->request->getGet('bidang');
        return redirect()->to($bidang ? '/owner/karyawan?bidang=' . urlencode($bidang) : '/owner/karyawan');
    }

    /**
     * Simpan karyawan baru dari modal "Tambah Karyawan".
     */
    public function store()
    {
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[100]',
            'bidang'        => 'required|in_list[' . implode(',', KaryawanModel::BIDANG_LIST) . ']',
            'no_hp'         => 'permit_empty|min_length[8]|max_length[20]',
            'email'         => 'permit_empty|valid_email',
            'tanggal_masuk' => 'required|valid_date',
            'gaji'          => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $model = new KaryawanModel();
        $model->insert([
            'nama'          => $this->request->getPost('nama'),
            'bidang'        => $this->request->getPost('bidang'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'gaji'          => $this->request->getPost('gaji'),
            'status'        => 'Aktif',
        ]);

        session()->setFlashdata('msg', 'Karyawan baru berhasil ditambahkan.');

        $bidang = $this->request->getPost('bidang_filter');
        return redirect()->to($bidang ? '/owner/karyawan?bidang=' . urlencode($bidang) : '/owner/karyawan');
    }

    /**
     * Perbarui data karyawan dari modal "Edit Karyawan".
     */
    public function update($id)
    {
        $model    = new KaryawanModel();
        $karyawan = $model->find($id);

        if (! $karyawan) {
            session()->setFlashdata('msg', 'Data karyawan tidak ditemukan.');
            return redirect()->to('/owner/karyawan');
        }

        $rules = [
            'nama'          => 'required|min_length[3]|max_length[100]',
            'bidang'        => 'required|in_list[' . implode(',', KaryawanModel::BIDANG_LIST) . ']',
            'no_hp'         => 'permit_empty|min_length[8]|max_length[20]',
            'email'         => 'permit_empty|valid_email',
            'tanggal_masuk' => 'required|valid_date',
            'gaji'          => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $model->update($id, [
            'nama'          => $this->request->getPost('nama'),
            'bidang'        => $this->request->getPost('bidang'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'gaji'          => $this->request->getPost('gaji'),
        ]);

        session()->setFlashdata('msg', "Data {$this->request->getPost('nama')} berhasil diperbarui.");

        $bidang = $this->request->getPost('bidang_filter');
        return redirect()->to($bidang ? '/owner/karyawan?bidang=' . urlencode($bidang) : '/owner/karyawan');
    }

    /**
     * Hapus data karyawan permanen (tombol "Hapus" di modal konfirmasi).
     */
    public function delete($id)
    {
        $model    = new KaryawanModel();
        $karyawan = $model->find($id);

        if (! $karyawan) {
            session()->setFlashdata('msg', 'Data karyawan tidak ditemukan.');
            return redirect()->to('/owner/karyawan');
        }

        $model->delete($id);

        session()->setFlashdata('msg', "Data {$karyawan['nama']} berhasil dihapus.");

        $bidang = $this->request->getPost('bidang') ?? $this->request->getGet('bidang');
        return redirect()->to($bidang ? '/owner/karyawan?bidang=' . urlencode($bidang) : '/owner/karyawan');
    }
}