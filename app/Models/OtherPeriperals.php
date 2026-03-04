<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherPeriperals extends Model
{
    protected $table = 'other_periperals';

    protected $primaryKey = 'id';

    public $incrementing = false; // because id is varchar

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'custudian_id',
        'name',
        'brand',
        'serial',
        'year',
        'remarks',
        'deleted'
    ];
}
