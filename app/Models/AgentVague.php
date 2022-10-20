<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentVague extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public  function agents(){
        return $this->hasMany('App\Models\User','agent_id');
    }
    public function vague()
    {
        return $this->belongsTo('App\Models\Vague');
    }
}
