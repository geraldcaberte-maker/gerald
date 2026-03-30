<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
  
protected $table = 'positions';
   

    public function Positiontype()
    {
        return $this->hasOne(PositionTypes::class, 'id' , 'position_types_id');
    }

}
