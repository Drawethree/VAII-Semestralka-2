<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
        'article_id',
    ];

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
