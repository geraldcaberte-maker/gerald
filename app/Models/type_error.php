<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_error extends Model
{
   protected $table = 'type_error';
    protected $fillable = [
      'id',
        'description',
    ];
  
    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
}
