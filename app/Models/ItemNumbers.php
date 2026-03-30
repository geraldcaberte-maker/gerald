<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNumbers extends Model
{
  
protected $table = 'item_numbers';
   
   public function Sections()
    {
        return $this->hasOne(Sections::class, 'id' , 'sections_id');
    }

    public function Detailed()
    {
        return $this->hasOne(Sections::class, 'id' , 'detailed_at');
    }

    /**
     * Gets query for [[Positions]].
     *
     * @return \yii\db\ActiveQuery|PositionsQuery
     */
    public function Positions()
    {
        return $this->hasOne(Positions::class, 'id' , 'positions_id');
    }

    public function Positiontype()
    {
        return $this->hasOne(PositionTypes::class, 'id' , 'position_types_id');
    }

    public function Divisions(){
        return $this->hasOne(Divisions::class, 'id' , 'divisions_id');
    }
}
