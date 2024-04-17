<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    //
    protected $fillable = [
        'image_id', 'nombre_liga', 'temporada_id', 'tipo_id', 'rama_id','sede_id', 'fecha_inicio', 'fecha_fin','estatu_id','user_id',
    ];

    //Se agregó esta función del Modelo Imagen
    public function image(){
      return $this->belongsTo('App\Image');
    }

    //Se agregó esta función del Modelo Imagen
    public function temporada(){
      return $this->belongsTo('App\Temporada');
    }

    //Se agregó esta función del Modelo Imagen
    public function sede(){
      return $this->belongsTo('App\Sede');
    }

    //Se agregó esta función del Modelo Imagen
    public function Tipo(){
      return $this->belongsTo('App\Tipo');
    }

    //Se agregó esta función del Modelo Imagen
    public function Rama(){
      return $this->belongsTo('App\Rama');
    }

    public function User(){
      return $this->belongsTo('App\User')->withDefault([
        'name' => null, 
      ]);
    }
}
