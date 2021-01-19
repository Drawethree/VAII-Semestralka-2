<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    public function articles()
    {
        return $this->hasMany('\App\Models\Article');
    }

    public function getAvatarPath() {
        return '/assets/img/forum/' . $this->id . '.png';
    }
}
