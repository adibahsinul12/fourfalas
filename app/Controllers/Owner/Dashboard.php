<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\RatingModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $karyawanModel = new KaryawanModel();
        $ratingModel   = new RatingModel();
        $orderModel    = new OrderModel();

        // Ambil data penjualan per bulan tahun berjalan
        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $penjualanPerBulan = array_fill(1, 12, 0); // default 0 tiap bulan
        $pesananPerBulan   = array_fill(1, 12, 0);

        $monthlySales = $orderModel->getMonthlySales();
        foreach ($monthlySales as $row) {
            $penjualanPerBulan[(int) $row['bulan']] = (float) $row['total'];
            $pesananPerBulan[(int) $row['bulan']]   = (int) $row['jumlah_pesanan'];
        }

        // Total pendapatan & total pesanan sekarang dihitung dari data yang sama dengan grafik,
        // supaya keduanya selalu sinkron (bukan angka dummy lagi)
        $totalPendapatan = array_sum($penjualanPerBulan);
        $totalPesanan    = array_sum($pesananPerBulan);

        $data = [
            'total_pendapatan' => $totalPendapatan,
            'total_pesanan'    => $totalPesanan,
            'total_pelanggan'  => 25, // masih dummy, belum ada sumber data pelanggan unik

            'total_karyawan' => $karyawanModel->countAllResults(),
            'per_bidang'     => $karyawanModel->countByBidang(),

            'rata_rating'    => $ratingModel->getAverageRating(),
            'total_rating'   => $ratingModel->countAllResults(),
            'rating_terbaru' => $ratingModel->getRecent(5),

            'sales_chart_labels' => $namaBulan,
            'sales_chart_data'   => array_values($penjualanPerBulan),
        ];

        return view('owner/dashboard', $data);
    }
}