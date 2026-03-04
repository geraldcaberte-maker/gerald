<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class error_and_concern extends Model
{
      protected $table = 'e_a_c';
protected $fillable = [
        'id',
'Date',
'system_id',
 'type_error',
  'requirments',
   'module',
    'action',
    'update_status',
    'target_start',
     'target_end',
 'status',
 'date_accomplished',
 'date_reviewed',
'upload_date',
'backup_date',
 'backup_location',
 'filelink',
  'remarks',
    ];
   public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
 
    use HasFactory;
       public function error_and_concern()
    {
        return $this->belongsTo(error_and_concern::class, 'type_error');
    }
}
