<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    // User.phpとのリレーションを追加

    public function todos()
    {
        return $this->hasMany('App\Todo');
    }
}
