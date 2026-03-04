<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questioner extends Model
{
  
protected $table = 'questioner';
    protected $fillable = [
        'id',
        'category_id',
        'question',
        'sorting',
    ];
    

    
    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
}
