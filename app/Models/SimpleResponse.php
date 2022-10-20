<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleResponse extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function simplequiz()
    {
        return $this->belongsTo('App\Models\SimpleQuiz');
    }
    public function responseAgent(){
        return $this->hasOne('App\Models\ResponseAgent');
    }
}
