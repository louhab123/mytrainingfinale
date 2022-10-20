<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationFi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['*'];
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
