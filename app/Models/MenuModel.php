<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'category_id',
        'menu_name',
        'description',
        'image_path',
        'is_recommended',
        'is_active',
        'status',
        'requested_by',
        'approved_by',
        'rejected_reason',
        'approved_at',
    ];

    public function getApprovedMenus()
    {
        return $this->where('status', 'approved')->findAll();
    }

    public function getPendingMenus()
    {
        return $this->where('status', 'pending')->findAll();
    }

    public function approveMenu($id, $ownerId)
    {
        return $this->update($id, [
            'status'      => 'approved',
            'approved_by' => $ownerId,
            'approved_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function rejectMenu($id, $ownerId, $reason = null)
    {
        return $this->update($id, [
            'status'          => 'rejected',
            'approved_by'     => $ownerId,
            'approved_at'     => date('Y-m-d H:i:s'),
            'rejected_reason' => $reason,
        ]);
    }
}