<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response_answer extends Model
{
   protected $table = 'response_answer'; // o 'responses' kung plural ang table

    protected $fillable = [
        'id',
         'response_id',
        'question_id',
        'answer'
        
    ]; 
    use HasFactory;
}
