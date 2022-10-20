<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public  function resources(){
        return $this->hasMany('App\Models\Resouces');
    }
    public  function noteagent(){
        return $this->hasMany('App\Models\NoteAgent');
    }
    public function responsesSimpleQuiz()
    {
        return $this->hasMany('App\Models\ResponseAgent','agent_id');
    }
    public function activite()
    {
        return $this->belongsToMany('App\Models\Activite','user_activite','user_id','activite_id');
    }
    public function agents_vague()
    {
        return $this->belongsToMany('App\Models\AgentVague');
    }
    public function messages(){
        return $this->hasMany('App\Models\Message');
    }
}
