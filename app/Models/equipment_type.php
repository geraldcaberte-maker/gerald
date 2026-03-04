<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipment_type extends Model
{
     protected $table = 'type_equipment';
    protected $fillable = [
        'id',
        'status',
        'category',
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
}
