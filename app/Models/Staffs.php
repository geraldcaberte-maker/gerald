<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
  
protected $table = 'staffs';
    
   public function FullName()
   {
      $middle = $this->middle_name ? "{$this->middle_initial}. " : '';
      return "{$this->first_name} $middle{$this->last_name}";
   }


   public function FullName1()
   {
      $l = strtoupper($this->last_name);
      if ($m = @$this->middle_initial) {
         $m .= '.';
      }
      return trim("$l, {$this->first_name} $m");
   }

   public function FullName2()
   {
      if ($m = @$this->middle_initial) {
         $m .= '. ';
      }
      return trim("{$this->first_name} {$m}{$this->last_name}");
   }
   public function Staffemployment()
   {
      return $this->hasOne(StaffEmployment::class, 'user_id', 'user_id');
   }
   public function FullName3()
   {
      return strtoupper($this->fullname1);
   }
    public function Designation()
    {
        return strtoupper(join(', ', array_filter([($des = @$this->role->designation) ? $des : @$this->position->position_name], fn($s) => trim($s))));
    }
    public function Position()
    {
        return (($sp = ($se = $this->staffemployment)?->staffplantilla) ? $sp->itemnumbers : $se?->staffcos)?->positions;
    }
    public function Section()
    {
        return ($sp = ($se = $this->staffemployment)?->staffplantilla) ? $sp->itemnumbers->detailed :
            $se?->staffcos->sections;
    }

    public function Section_id()
    {
        return ($sp = ($se = $this->staffemployment)?->staffplantilla) ? $sp->itemnumbers->detailed->id :
            $se?->staffcos->sections->id;
    }
    public function Division()
    {
        return ($sp = ($se = $this->staffemployment)?->staffplantilla) ? $sp->itemnumbers->detailed->divisions :
            $se?->staffcos->sections->divisions;
    }

}
