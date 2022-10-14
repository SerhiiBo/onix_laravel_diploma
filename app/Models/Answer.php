<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
