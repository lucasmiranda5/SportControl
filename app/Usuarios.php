<?php

namespace sportcontrol;

use Illuminate\Foundation\Auth\User as Authenticatable;




class Usuarios extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuarios';
    public $timestamps = true;
    protected $fillable = [
        'nome', 'email', 'password','usuario','ativo','role','campus'
    ];
   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
