<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand'; // exact table name mo sa Laragon
    protected $fillable = ['name', 'status']; // fields na pwede i-update via AJAX
}
