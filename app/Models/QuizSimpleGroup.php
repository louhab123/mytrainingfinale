<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSimpleGroup extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public  function SimpleQuizs(){
        return $this->hasMany('App\Models\SimpleQuiz');
    }
    public  function SimpleResponses(){
        return $this->hasMany('App\Models\ResponseAgent');
    }
    public  function notes(){
        return $this->hasMany('App\Models\NoteAgent','quizsimplegroup_id');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
