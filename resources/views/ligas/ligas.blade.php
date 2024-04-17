<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css" >

@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div class="container">


      <div class="page-header">
        <h2>Ligas Registradas</h2>
      </div>

      <div class="row">
        <h5><a href="{{ url('home') }}" type="button" class="btn btn-primary" style="margin-left: 15px;">HOME</a></h5>
        <h5><a href="{{ url('ligas/create') }}" type="button" class="btn btn-primary" style="margin-left: 5px;">Agregar Liga</a></h5>

        @if(Auth::user()->role_id == 1)
        <h5><a href="{{ url('admin/users/create') }}" type="button" class="btn btn-dark" style="margin-left: 5px;">Agregar Usuarios</a></h5>
        <h5><a href="{{ url('admin/users') }}" type="button" class="btn btn-dark" style="margin-left: 5px;">Ver Usuarios</a></h5>
        @endif

      </div>

        <table class="table table-striped table-hover">
          <tr>
            <th>ID</th>
            <th>IMAGEN</th>
            <th>NOMBRE LIGA</th>
            <th>TEMPORADA</th>
            <th>SEDE</th>
            <th>TIPO</th>
            <th>RAMA</th>
            <th>FECHA INICIO</th>
            <th>USUARIO</th>

          </tr>


        @if($ligas)
          @foreach($ligas as $liga)

          <tr>

            <td>{{$liga->id}}</td>

            @if($liga->image)
              <td><img src="{{ URL::to('/images/' . $liga->image->nombre_imagen) }}" class="redondo" /></td>
            @else
              <td><img src="{{ URL::to('/images/liga-no-image.png') }}" height="45px"/></td>
            @endif

            @if(Auth::user()->role_id == 1)
            <td><strong><a href="{{ route('ligas.edit', $liga->id) }}"> {{ $liga->nombre_liga }} </a></strong></td>
            @else
            <td><strong> {{ $liga->nombre_liga }} </strong></td>
            @endif

            @if($liga->temporada->nombre_temporada)
              <td>{{ $liga->temporada->nombre_temporada }}</td>
            @else <td>- - -</td> @endif

            @if($liga->sede->nombre_sede)
              <td>{{ $liga->sede->nombre_sede }}</td>
            @else <td>- - -</td> @endif

            <td>{{ $liga->tipo->nombre_tipo }}</td>
            <td>{{ $liga->rama->nombre_rama }}</td>
            <td>{{ $liga->fecha_inicio }}</td>
            <td>{{ $liga->user->name }} {{ $liga->user->last_name }}</td>

          @endforeach
        @endif
        </table>

</body>
@endsection
