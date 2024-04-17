<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Estilo datepicker-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- jQuery-->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script> <!-- datepicker jQuery-->
<script src="{{asset('js/datepickerJQ/datepickerJQ-es.js')}}"></script> <!-- datepicker Español-->

<style>
  .redondoPreview {
    object-fit: cover; border-radius: 50%;
    height: 100px; width: 100px;
  }
</style>

<script type="text/javascript">

function deleteConfirmation(id) {
    Swal.fire({
        title: "¿Desea eliminar la liga?",
        text: "¡Por favor asegúrese y luego confirme!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "¡Sí, eliminar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: !0
    }).then(function (e) {

        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "{{url('/deleteLiga')}}/" + id,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {

                  if (results.success === true) {
                    Swal.fire("¡Hecho!", results.message, "success");

                    setTimeout(function() {
                        window.location.href = "{{ url('home') }} ";
                    }, 1500);
                  } else {
                      Swal.fire("¡Error!", results.message, "error");
                      setTimeout(function() {
                          window.location.href = "{{ url('home') }} ";
                      }, 1500);
                  }
                }
            });

        } else {
            e.dismiss;
        }

    }, function (dismiss) {
        return false;
    })
}

/* Calendario jQuery */
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
  <div class="card-header"><strong>Editar Liga:</strong> <span style="margin-left: 5px;">completa la información,
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


      {!! Form::model($liga,['method' => 'PATCH', 'action' => ['LigasController@update', $liga->id], 'files'=>true]) !!}
      <table class="table table-bordered">

        <tr>

          @if($liga->image)
          <td><img src="{{ URL::to('/images/' . $liga->image->nombre_imagen) }}" class="redondoPreview"/>
            <small style="margin-left: 7px;" class="form-text text-muted">Imágen actual.</small>
          </td>
          @else
          <td><img src="{{ URL::to('/images/liga-no-image.png') }}" height="100px"/>
            <small style="margin-left: 7px;" class="form-text text-muted">Imágen actual.</small>
          </td>
          @endif

          <td style="width:275px">
            <img src="{{ URL::to('/images/no-image.png') }}" id="profile-img-tag" class="redondoPreview"/>
            <small style="margin-left: 7px;" class="form-text text-muted">Vista previa.</small>
          </td>
        </tr>

        <tr>
          <td colspan="2">
          {!! Form::file('image_id', array('id'=>'image_input', 'class' => 'btn btn-secondary', 'style'=>'width:100%')) !!}
          </td>
        </tr>

        <tr>
          <td>
          {!! Form::label('name', '* Nombre de la liga:') !!}
          </td>
          <td>
          {!! Form::text('nombre_liga', null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
          <small style="color:#b0b0b0">Por ejemplo: Liga MX</small>
          </td>
        </tr>

        <tr>
          <td>
          {!! Form::label('tempo', '* Nombre de la temporada:') !!}
          </td>
          <td>
          {!! Form::text('temporada_id', $liga->temporada->nombre_temporada,
                    ['class' => 'form-control','placeholder' => '' ]) !!}
          <small style="color:#b0b0b0">Por ejemplo: Temporada 2020-2021</small>
          </td>
        </tr>

        <tr>
          <td>
          {!! Form::label('fecha', '* Fecha en que inicia la liga:') !!}
          </td>
          <td>
          {!! Form::text('fecha_inicio', null,
                ['class' => 'form-control' ,'placeholder' =>'','id'=>'fecha_ini' ]) !!}
          <small style="color:#b0b0b0">Por ejemplo: 01-01-2020</small>
          </td>
        </tr>

        <tr>
          <td>
          {!! Form::label('lugar', '* Ciudad ó lugar dónde se realiza:') !!}
          </td>
          <td>
          {!! Form::text('sede_id', $liga->sede->nombre_sede,
                      ['class' => 'form-control' ,'placeholder' => '']) !!}
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
                  $liga->tipo->nombre_tipo, ['class' => 'form-control']) !!}
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
                      $liga->rama->nombre_rama, ['class' => 'form-control']) !!}
          </td>
        </tr>

        <tr>
          <td>
          {!! Form::submit('Actualizar Información', ['class' => 'btn btn-primary']) !!}
          </td>
          <td>
          <a href="{{ url('ligas') }}" type="button" class="btn btn-outline-primary" >Cancelar</a>
          </td>
        </tr>


      </table>
      {!! Form::close() !!}

      <button class="btn btn-danger" onclick="deleteConfirmation({{$liga->id}})">Eliminar mi liga</button>

<!--
{!! Form::model($liga,['method' => 'DELETE', 'action' => ['LigasController@destroy', $liga->id]]) !!}
    {!! Form::submit('Eliminar Liga', ['class' => 'btn btn-dark']) !!}
{!! Form::close() !!}
-->



</div>

</div>

</div>
</body>

@endsection
