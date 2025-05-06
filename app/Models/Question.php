<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'survey_id',
        'question_text',
        'question_type', // 'single', 'multiple', 'open'
        'question_order',
    ];

    // Relacja: ankieta, do której należy pytanie
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relacja: odpowiedzi na pytanie
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
