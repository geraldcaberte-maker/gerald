<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // optional, default Laravel

    protected $primaryKey = 'ID'; // only if uppercase
    public $incrementing = true;   // only if auto-increment INT
    protected $keyType = 'int';    // default

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
