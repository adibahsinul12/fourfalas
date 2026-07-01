<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'cafe_name',
        'logo_path',
        'operating_hours_open',
        'operating_hours_close',
        'service_tax_percent',
        'contact_info',
    ];
    protected $returnType = 'array';

    /**
     * Ambil baris settings pertama (dianggap cuma ada 1 baris konfigurasi).
     * Kalau belum ada sama sekali, kembalikan default kosong.
     */
    public function getSettings(): array
    {
        $row = $this->first();

        if (! $row) {
            return [
                'id'                     => null,
                'cafe_name'              => '',
                'logo_path'              => null,
                'operating_hours_open'   => '08:00:00',
                'operating_hours_close'  => '22:00:00',
                'service_tax_percent'    => 10.00,
                'contact_info'           => '',
            ];
        }

        return $row;
    }

    /**
     * Simpan settings. Kalau baris belum ada, insert baru (id = 1).
     * Kalau sudah ada, update baris yang ada.
     */
    public function saveSettings(array $data): void
    {
        $existing = $this->first();

        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $data['id'] = 1;
            $this->insert($data);
        }
    }
}