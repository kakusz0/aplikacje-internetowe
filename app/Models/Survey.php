<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_public',
        'is_named',
        'expires_at',
    ];

    // Relacja: autor ankiety
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacja: pytania w ankiecie
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relacja: odpowiedzi
    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }
}