<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Questioner;
use App\Models\Response;

class ResponseAnswer extends Model
{
    protected $table = 'response_answers';

    protected $fillable = [
        'response_id',
        'question_id',
        'answer'
    ];

    // 🔗 relation to response (parent)
    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    // 🔗 relation to question
    public function question()
    {
        return $this->belongsTo(Questioner::class, 'question_id');
    }
}