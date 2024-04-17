<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'foto_id', 'name', 'last_name', 'email', 'password','telefono', 'role_id', 'liga_id','permiso_id','suscripcion_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Se agregó esta función de Modelo Rol
    public function role(){
      return $this->belongsTo('App\Role');
    }

    /* La Foto Pertenece a Usuario*/   //relacion De hija a Padre
    public function foto(){
      return $this->belongsTo('App\Foto');
    }

    /* Un Usuario tiene una Liga*/    //relación De Padre a hija
    public function liga(){
       return $this->hasOne('App\Liga')->withDefault([
         'id' => null,
       ]);
    }

}
