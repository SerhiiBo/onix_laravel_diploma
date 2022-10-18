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

    public function users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
