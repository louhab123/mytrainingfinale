<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function activite()
    {
        return $this->belongsTo('App\Models\Activite');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
