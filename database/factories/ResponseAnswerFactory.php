<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResponseAnswer>
 */
class ResponseAnswerFactory extends Factory
{
public function index()
{      
    $responses = Response::with('answers.question')->get();
    return view('response.index', compact('responses'));
}
}
