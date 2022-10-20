<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleQuiz extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public  function responses(){
        return $this->hasMany('App\Models\SimpleResponse');
    }

    public  function service(){
        return $this->belongsTo('App\Models\Service');
    }
    public  function quizsimplegroup(){
        return $this->belongsTo('App\Models\QuizSimpleGroup');
    }
   public function agentResponses(){
    return $this->hasMany('App\Models\ResponseAgent');
   }
}

