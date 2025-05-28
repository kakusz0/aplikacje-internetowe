<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'title',
        'description',
        'is_public',
        'is_named',
        'expires_at'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_named' => 'boolean',
        'expires_at' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($survey) {
            if (empty($survey->uuid)) {
                $survey->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }


    public function getRouteKeyName()
    {
        return 'uuid';
    }
}