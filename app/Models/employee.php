<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
     protected $connection = 'employee'; // equivalent to getDb()

    protected $table = 'staffs';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'id_number',
        'first_name',
        'last_name',
        'middle_name',
        'middle_initial',
        'extension_name',
        'email',
        'secondary_email',
        'birthdate',
        'sex',
        'telephone_number',
        'cellphone_number',
        'civil_status',
        'status_of_appointment_id',
        'deleted',
        'item_number',
        'employmentstatus',
        'appointment_type_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'birthdate' => 'date',
    ];

    use HasFactory;
}
