<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class technical extends Model
{
protected $table = 'technical';
    protected $fillable = [
        'id',
        'type_computer',
        'model',
        'status',
    ];
  
    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
}
