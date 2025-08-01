<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'respondent_id',
        'question_id',
        'answer_text'
    ];

    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }
}