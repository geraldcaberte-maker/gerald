<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseAnswer extends Controller
{
public function question()
{
    return $this->belongsTo(Questioner::class, 'question_id');
}

}
