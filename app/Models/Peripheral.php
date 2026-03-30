<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model
{
   protected $table = 'peripherals';

    protected $fillable = [
        'id',
        'category_id',
        'peripheral',
        'brand',
        'serial_no',
        'year'
    
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    
    use HasFactory;
}

