<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'impact','easy','confidence','avg'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
