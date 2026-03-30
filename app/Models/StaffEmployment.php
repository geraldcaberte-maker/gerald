<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffEmployment extends Model
{
  
protected $table = 'staff_employment';
   
   public function Staffplantilla()
      {
         return $this->hasOne(StaffAssumption::class, 'user_id' , 'user_id');
      }

      public function Staffcos()
      {
         return $this->hasOne(ContractServicePosition::class, 'user_id' , 'user_id');
         //->orderBy(['contract_of_service.created_at' => SORT_DESC]);
      }
}
