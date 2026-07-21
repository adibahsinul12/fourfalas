<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();

        // Filter rentang tanggal, default: bulan berjalan
        $tanggalMulai  = $this->request->getGet('start') ?: date('Y-m-01');
        $tanggalSelesai = $this->request->getGet('end') ?: date('Y-m-d');

        // Filter mode grafik: 'harian' atau 'bulanan', default harian
        $periode = $this->request->getGet('period') ?: 'harian';
        if (!in_array($periode, ['harian', 'bulanan'])) {
            $periode = 'harian';
        }

        $data = [
            'tanggal_mulai'    => $tanggalMulai,
            'tanggal_selesai'  => $tanggalSelesai,
            'periode'          => $periode,
            'total_pendapatan' => $laporanModel->getTotalPendapatan($tanggalMulai, $tanggalSelesai),
            'total_transaksi'  => $laporanModel->getTotalTransaksi($tanggalMulai, $tanggalSelesai),
            'total_dibatalkan' => $laporanModel->getTotalDibatalkan($tanggalMulai, $tanggalSelesai),
            'per_metode'       => $laporanModel->getPendapatanPerMetode($tanggalMulai, $tanggalSelesai),
            'menu_terlaris'    => $laporanModel->getMenuTerlaris($tanggalMulai, $tanggalSelesai),
            'daftar_transaksi' => $laporanModel->getDaftarTransaksi($tanggalMulai, $tanggalSelesai),
        ];

        // Pilih data grafik sesuai mode yang dipilih
        $data['pendapatan_harian'] = $periode === 'bulanan'
            ? $laporanModel->getPendapatanBulanan($tanggalMulai, $tanggalSelesai)
            : $laporanModel->getPendapatanHarian($tanggalMulai, $tanggalSelesai);

        $data['rata_rata_transaksi'] = $data['total_transaksi'] > 0
            ? $data['total_pendapatan'] / $data['total_transaksi']
            : 0;

        return view('owner/laporan', $data);
    }
}