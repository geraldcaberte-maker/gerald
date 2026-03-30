<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
  
protected $table = 'sections';
   

    public function Divisions(){
        return $this->hasOne(Divisions::class, 'id' , 'divisions_id');
    }
}
