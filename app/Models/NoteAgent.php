<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteAgent extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function agent()
    {
        return $this->belongsTo('App\Models\User','agent_id');
    }
    public  function quizsimplegroup(){
        return $this->belongsTo('App\Models\QuizSimpleGroup');
    }
    public  function service(){
        return $this->belongsTo('App\Models\Service');
    }
    public  function activite(){
        return $this->belongsTo('App\Models\Activite');
    }
}
