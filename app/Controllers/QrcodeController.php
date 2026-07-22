<?php

namespace App\Controllers;

use App\Models\TableModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;

class QrcodeController extends BaseController
{
    public function index()
    {
        $tableModel = new TableModel();
        $tables = $tableModel->orderBy('table_number', 'ASC')->findAll();

        $baseUrl = base_url('pelanggan');

        $data['qrUmum'] = $this->generateQr($baseUrl);

        $data['qrMeja'] = [];
        foreach ($tables as $table) {
            $nomor = $table['table_number'];
            $data['qrMeja'][$nomor] = $this->generateQr($baseUrl . '?meja=' . $nomor);
        }

        return view('owner/qrcode_print', $data);
    }

    private function generateQr(string $url): string
    {
        $builder = new Builder(
            writer: new SvgWriter(),
            data: $url,
            size: 320,
            margin: 12,
        );

        $result = $builder->build();

        return $result->getDataUri();
    }
}