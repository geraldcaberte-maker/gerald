<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

protected $table = 'category';
    protected $fillable = [
        'id',
        'description',
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    public function description()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    use HasFactory;
}