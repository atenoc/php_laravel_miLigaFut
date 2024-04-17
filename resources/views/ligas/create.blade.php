<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script> <!-- datepicker jQuery-->
<script src="{{asset('js/datepickerJQ/datepickerJQ-es.js')}}"></script>

<style>
  .redondoImg {
    object-fit: cover; border-radius: 50%;
    height: 60px; width: 60px;
  }
</style>

<script>

    /* datepicker jQuery */
    jQuery(document).ready(function($) {

      $( function() {
        //$( "#fecha_ini" ).datepicker();
        $( "#fecha_ini" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: 0 });
      } );

    });

    /* Preview Imágen */
    jQuery(document).ready(function($) {

      function readURL(input) {
        console.log("input: "+input)
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image_input").change(function(){
        readURL(this);
    });

  });

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
    <i class='fa fa-soccer-ball-o' style='font-size:15px;color:#343a40'></i>
    <strong>Nueva Liga:</strong> <span style="margin-left: 5px;">completa la información,
  los campos con (*) son obligatorios</span></div>
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

    {!! Form::open(['method' => 'POST', 'action' => 'LigasController@store', 'files'=>true]) !!}
    <table class="table table-bordered">

      <tr>
        <td>
        {!! Form::label('name', '* Nombre de la liga:') !!}
        </td>
        <td style="width:280px">
        {!! Form::text('nombre_liga', null, ['class' => 'form-control', 'placeholder' => '' ] ) !!}
        <small style="color:#b0b0b0">Por ejemplo: Liga MX</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('imagen', 'Imágen ó logo de la liga:') !!}
        </td>
        <td>
        {!! Form::file('image_id', array('id'=>'image_input', 'class' => 'btn btn-secondary', 'style'=>'width:166px')) !!}
        <img src="{{ URL::to('/images/no-image.png') }}" id="profile-img-tag" width="50" style="margin-left: 15px;" class="redondoImg"/>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('tempo', '* Nombre de la temporada:') !!}
        </td>
        <td>
        {!! Form::text('temporada_id' , null, ['class' => 'form-control','placeholder' => '' ] ) !!}
        <small style="color:#b0b0b0">Por ejemplo: Temporada 2020-2021</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('fecha', '* Fecha de inicio de la liga:') !!}
        </td>
        <td>
        {!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'id'=>'fecha_ini' ] ) !!}
        <small style="color:#b0b0b0">Por ejemplo: 01-01-2020</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('lugar', '* Ciudad o lugar dónde se realiza:') !!}
        </td>
        <td>
        {!! Form::text('sede_id', null, ['class' => 'form-control' ,'placeholder' => '']) !!}
        <small style="color:#b0b0b0">Por ejemplo: Zaragoza Puebla</small>
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('tipo', 'Tipo:') !!}
        </td>
        <td>
        {!! Form::select('tipo_id',
              array('- - -' => 'Selecciona un tipo',
               'Fútbol Soccer' => 'Fútbol Soccer',
               'Fútbol Rápido' => 'Fútbol Rápido'),
                null, ['class' => 'form-control']) !!}
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('rama', 'Rama:') !!}
        </td>
        <td>
        {!! Form::select('rama_id',
              array('- - -' => 'Selecciona una rama',
                     'Varonil' => 'Varonil',
                     'Femenil' => 'Femenil'),
                     null, ['class' => 'form-control']) !!}
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::label('estatus', 'Estatus:') !!}
        </td>
        <td>
        {!! Form::text('estatu_id','Activo', ['class' => 'form-control', 'readonly' => 'true'] ) !!}
        </td>
      </tr>

      <tr>
        <td>
        {!! Form::submit('Crear Liga', ['class' => 'btn btn-primary']) !!}
        </td>
        <td>
          <a href="{{ url('home') }}" type="button" class="btn btn-outline-primary" >Cancelar</a>
        </td>
      </tr>


    </table>
    {!! Form::close() !!}

  </div>

</div>

</div>
</body>

@endsection
