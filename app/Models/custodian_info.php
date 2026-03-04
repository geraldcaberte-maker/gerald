<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class custodian_info extends Model
{
        protected $table = 'custodian_info';  
    protected $fillable = [
        'id',
        'user_id',
        'brand',
        'model',
        'type',
        'serial_number',
        'mac_address',
        'ip_address',
    ];      
    
    public $incrementing = false; // dahil custom ID ka
    protected $keyType = 'string';
    use HasFactory;
}
