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
        'price', 
        'stock', 
        'image_path', 
        'is_recommended', 
        'is_active'
    ];
}