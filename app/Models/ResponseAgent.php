<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseAgent extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public  function SimpleResponse(){
        return $this->belongsTo('App\Models\SimpleResponse');
    }
    public function SimpleQuiz()
    {
        return $this->belongsTo('App\Models\SimpleQuiz');
    } 
    public function agent()
    {
        return $this->belongsTo('App\Models\User');
    }
}

