<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'respondent_id',
        'question_id',
        'answer_text', // dla pytań otwartych
    ];

    // Relacja: pytanie, na które udzielono odpowiedzi
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relacja: respondent, który udzielił odpowiedzi
    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }
}
