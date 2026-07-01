<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama', 'no_hp', 'email', 'poin', 'tanggal_gabung'];
    protected $useTimestamps    = false; // kolom updated_at diisi manual/otomatis oleh MySQL (ON UPDATE)

    // Cari member berdasarkan no HP (dipakai buat auto-link pas checkout nanti)
    public function findByPhone(string $noHp)
    {
        return $this->where('no_hp', $noHp)->first();
    }

    // Kalau no_hp sudah terdaftar, pakai member itu. Kalau belum, buat baru.
    public function findOrCreate(string $nama, string $noHp): int
    {
        $member = $this->findByPhone($noHp);

        if ($member) {
            return (int) $member['id'];
        }

        return (int) $this->insert([
            'nama'           => $nama,
            'no_hp'          => $noHp,
            'tanggal_gabung' => date('Y-m-d H:i:s'),
        ]);
    }
}