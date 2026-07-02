<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // PERBAIKAN: Kolom price dan stock sudah dihapus agar tidak bentrok dengan tabel varian
    protected $allowedFields    = [
        'category_id', 
        'menu_name', 
        'description', 
        'image_path', 
        'is_recommended', 
        'is_active'
    ];
}