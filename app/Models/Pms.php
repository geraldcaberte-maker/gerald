<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pms extends Model
{

protected $table = 'pms';
    protected $fillable = [
        'id',
        'owner_id',
        'division',
        'custodian_id',
        'ict_personnel',
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    public function description()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function questions()
    {
        return $this->hasMany(Questioner::class, 'category_id')->orderBy('sorting', 'ASC');
        return $this->hasMany(Questioner::class,'category_id');
    }
    
    public function staff()
    {
        return $this->belongsTo(Staffs::class, 'user_id');
    }

    use HasFactory;
}