<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractServicePosition extends Model
{
  
protected $table = 'contract_of_service';
   
   public function Positions()
    {
        return $this->hasOne(Positions::class, 'id' , 'position');
    }

    public function Divisions()
    {
        return $this->hasOne(Divisions::class, 'id' , 'division');
    }

    public function Sections()
    {
        return $this->hasOne(Sections::class, 'id' , 'section');
    }
}
