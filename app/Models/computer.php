<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    // optional: kung gusto mo i-allow ang mass assignment
    protected $fillable = ['brand', 'model', 'year'];
}
