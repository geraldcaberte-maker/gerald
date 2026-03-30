<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Response extends Model
{
    use HasFactory;

    protected $table = 'response'; // o 'responses' kung plural ang table

    protected $fillable = [
        'id',
         'application_id',
        'user_id',
        'division_id',
        'ict_staff',
        'custodian',
        'status',
        'remarks'
    ];

    protected $casts = [
        'answers' => 'array', // automatic JSON <-> array conversion
        'pms_id' => 'string'
    ];

    public $incrementing = false; // kung custom string ID
    protected $keyType = 'string';

  
}