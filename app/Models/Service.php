<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public  function resources(){
        return $this->hasMany('App\Models\Resouces');
    }
    public  function SimpleQuizs(){
        return $this->hasMany('App\Models\SimpleQuiz');
    }
    public  function FinaleQuizs(){
        return $this->hasMany('App\Models\FinaleQuiz');
    }
    public function formationsFI()
    {
        return $this->hasMany('App\Models\FormationFi');
    }
    public function formationsFc()
    {
        return $this->hasMany('App\Models\FormationFc');
    }
    public function quizssimplegroup()
    {
        return $this->hasMany('App\Models\QuizSimpleGroup');
    }
    public function vagues()
    {
        return $this->hasMany('App\Models\Vague');
    }
}
