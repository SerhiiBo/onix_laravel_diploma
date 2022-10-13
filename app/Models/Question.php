<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
    ];

   public function user()
    {
        return $this->hasOne(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
