<?php

namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    protected $table            = 'tables';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = ['table_number', 'capacity', 'type', 'status'];
}