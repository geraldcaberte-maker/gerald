<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssumption extends Model
{
  
protected $table = 'staff_assumption';
   
   public function Itemnumbers()
   {
      return $this->hasOne(ItemNumbers::class, 'id' , 'item_number_id');
   }
}
