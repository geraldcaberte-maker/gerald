<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sectype extends Model
{
        use HasFactory;

    protected $table = 'sections';

    // Many sections belong to one division
    public function division()
    {
        return $this->belongsTo(Divisions::class, 'divisions_id', 'id');
    }

}
