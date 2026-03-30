<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
   protected $table = 'application';

    protected $fillable = [
        'id',
        'category_id',
     'question_id',
        'name',
        'date_exp'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    
    use HasFactory;
       public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}

