<?php

namespace App\Controllers;

use App\Models\RatingModel;

class RatingCustomer extends BaseController
{
    /**
     * Tampilkan form rating & daftar ulasan singkat (opsional).
     */
    public function index()
    {
        return view('pelanggan/rating_pelanggan');
    }

    /**
     * Proses simpan rating baru dari pelanggan.
     * Tidak butuh session login karena pelanggan masuk via scan QR.
     */
    public function store()
    {
        $ratingModel = new RatingModel();

        $nama     = trim($this->request->getPost('nama_pelanggan'));
        $rating   = (int) $this->request->getPost('rating');
        $komentar = trim($this->request->getPost('komentar'));

        // Validasi dasar: nama wajib diisi, rating harus di antara 1-5
        if (empty($nama) || $rating < 1 || $rating > 5) {
            return redirect()->to(base_url('rating'))
                ->with('error', 'Mohon isi nama dan pilih rating bintang (1-5) terlebih dahulu.');
        }

        $ratingModel->insert([
            'id_pesanan'     => null, // Rating umum, tidak terikat pesanan tertentu
            'nama_pelanggan' => $nama,
            'rating'         => $rating,
            'komentar'       => $komentar,
            'tanggal'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('rating'))
            ->with('pesan_sukses', 'Terima kasih! Rating & ulasan kamu sudah kami terima.');
    }
}