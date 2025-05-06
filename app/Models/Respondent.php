<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable = [
        'survey_id',
        'user_id',
        'ip_address',
        'token',
        'started_at',
        'completed_at',
    ];

    // Relacja: ankieta, na którą odpowiedział respondent
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relacja: respondent, który udzielił odpowiedzi
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Relacja: użytkownik, jeśli respondent jest zarejestrowanym użytkownikiem
    public function user()
    {
        return $this->belongsTo(User::class)->nullable();
    }
}
