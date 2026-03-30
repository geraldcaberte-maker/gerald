<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class downtime extends Model
{
      protected $table = 'downtime';
    protected $fillable = [
        'id',
        'system',
        'description',
        'start',
        'end',
        'remarks',
     
    ];

    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    public $timestamps = false;
    use HasFactory;
     public function downtime()
    {
        return $this->belongsTo(downtime::class, 'system_id');
    }
}
