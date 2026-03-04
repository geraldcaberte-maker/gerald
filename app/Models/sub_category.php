<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_category extends Model
{
   protected $table = 'sub_category';
    protected $fillable = [
        'id',
        'category',
        'description',
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
   
}
