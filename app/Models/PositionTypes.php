<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionTypes extends Model
{
  
protected $table = 'position_types';
   

    public function Positions(){
        return $this->hasOne(Positions::class, 'id' , 'positions_id');
    }

}
