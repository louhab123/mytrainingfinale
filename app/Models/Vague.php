<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vague extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
    public function agents_vagues()
    {
        return $this->hasMany('App\Models\AgentVague');
    }
}
