<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }
    public  function resources(){
        return $this->hasMany('App\Models\Resouces');
    }
    public function vagues()
    {
        return $this->hasMany('App\Models\Vague');
    }
}
