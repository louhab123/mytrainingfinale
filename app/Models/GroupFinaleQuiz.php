<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFinaleQuiz extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public  function SimpleQuizs(){
        return $this->hasMany('App\Models\FinaleQuiz');
    }
}
