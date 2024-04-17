<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<script type="text/javascript">



</script>
@yield('scripts')



@extends('layouts.app')

@section('content')

<body class="bg-dark">

<!-- Page Content -->
<div class="container">

<div class="row justify-content-center">

<div class="card border-secondary mb-3" style="max-width: 50rem;">
  <div class="card-header">
    <i class='fas fa-user' style='font-size:15px;color:#343a40'></i>
    <strong>Nuevo Usuario:</strong> <span style="margin-left: 5px;">los campos con (*) son obligatorios</span></div>
  <div class="card-body text-secondary">

    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li> {{ $error }} </li>
        @endforeach
      </ul>
    </div>
    @endif

    {!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store', 'files'=>true]) !!}
    <table class="table table-bordered">
      <tr>
        <td>
        {!! Form::label('name', '* Nombre(s):') !!}
        </td>
        <td>
        {!! Form::text('name' , null, ['class' => 'form-control', 'placeholder' => '' ] ) !!}
        <small style="color:#b0b0b0">Escribe tu nombre(s)</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('last_name', 'Apellido(s):') !!}
        </td>
        <td>
        {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
        <small style="color:#b0b0b0">Escribe al menos un apellido</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('email', '* Correo:') !!}
        </td>
        <td>
        {!! Form::text('email' , null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
        <small style="color:#b0b0b0">Por ejemplo: algo@gmail.com</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('password', '* Contraseña:') !!}
        </td>
        <td>
        {!! Form::password('password' , null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
        <small style="color:#b0b0b0">Escribe al menos 8 caracteres</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('role', 'Rol:') !!}
        </td>
        <td>
        Admin {!! Form::radio('admin', 'admin') !!}
        User  {!! Form::radio('user', 'user', true) !!}
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('foto', 'Imágen de Perfil:') !!}
        </td>
        <td>
        {!! Form::file('foto_id', ['class' => 'btn btn-secondary']) !!}
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::submit('Crear Usuario' , ['class' => 'btn btn-primary']) !!}
        </td>
        <td>
        <a href="{{ url('admin/users') }}" type="button" class="btn btn-outline-primary" >Cancelar</a>
        </td>
      </tr>


    </table>
    {!! Form::close() !!}


  </div>

</div>

</div>
</body>

@endsection
