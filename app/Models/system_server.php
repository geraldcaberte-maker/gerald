<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class system_server extends Model
{
     protected $table = 'system_server';
    protected $fillable = [
        'id',
        'system_server',
     
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    public $timestamps = false;
    use HasFactory;
    //public function category()
    //{
      //  return $this->belongsTo(Category::class, 'category_id');
   // }
    
    use HasFactory;
}
