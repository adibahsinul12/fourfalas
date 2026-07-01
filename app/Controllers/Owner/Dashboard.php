<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\RatingModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $karyawanModel = new KaryawanModel();
        $ratingModel   = new RatingModel();

        $data = [
            // TODO: ganti dengan data asli begitu tabel transaksi/pesanan sudah ada.
            // Sengaja dipisah jelas biar gampang dicari & diganti nanti.
            'total_pendapatan' => 4850000,
            'total_pesanan'    => 37,
            'total_pelanggan'  => 25,
            'is_dummy_sales'   => true,

            'total_karyawan' => $karyawanModel->countAllResults(),
            'per_bidang'     => $karyawanModel->countByBidang(),

            'rata_rating'    => $ratingModel->getAverageRating(),
            'total_rating'   => $ratingModel->countAllResults(),
            'rating_terbaru' => $ratingModel->getRecent(5),
        ];

        return view('owner/dashboard', $data);
    }
}