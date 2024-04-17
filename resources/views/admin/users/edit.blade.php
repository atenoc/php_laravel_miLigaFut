<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery-->
<script src="{{asset('js/jquery.min.js')}}"></script>

<style>
  .redondoPreview {
    object-fit: cover; border-radius: 50%;
    height: 100px; width: 100px;
  }
</style>

<script type="text/javascript">

function deleteConfirmation(id) {
  Swal.fire({
      title: "¿Eliminar usuario?",
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
                url: "{{url('/deleteUser')}}/" + id,
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


@if (session('error_pass'))

      <script type="application/javascript">

        $(function() {
            $('.modal').modal('show');

            mostrarMensaje();
        });

        function mostrarMensaje(){
          $("#aviso").css("display","block");
        }

      </script>
      @yield('scripts')

@endif


@extends('layouts.app')

@section('content')

  <body class="bg-dark">

  <!-- Page Content -->
  <div class="container">


  <div class="row justify-content-center">

  <div class="card border-secondary mb-3" style="max-width: 50rem;">
    <div class="card-header"><strong>Perfil de Usuario:</strong> <span style="margin-left: 5px;">los campos con (*) son obligatorios</span></div>

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

          {!! Form::model($user,['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id], 'files'=>true]) !!}
          <table class="table table-bordered">

            <tr>

              @if($user->foto)
              <td><img src="{{ URL::to('/images/' . $user->foto->ruta_foto) }}" height="100px"/>
                <small style="margin-left: 7px;" class="form-text text-muted">Perfil actual.</small>
              </td>
              @else
              <td><img src="{{ URL::to('/images/user-no-image.png') }}" height="100px"/>
                <small style="margin-left: 7px;" class="form-text text-muted">Perfil actual.</small>
              </td>
              @endif

              <td>
                <img src="{{ URL::to('/images/no-image.png') }}" id="profile-img-tag" class="redondoPreview"/>
                <small style="margin-left: 7px;" class="form-text text-muted">Vista previa.</small>
              </td>

            </tr>
            <tr>
              <td colspan="2">
              {!! Form::file('foto_id', array('id'=>'image_input', 'class' => 'btn btn-secondary')) !!}
              </td>
            </tr>

            <tr>
              <td>
              {!! Form::label('name', '* Nombre(s):') !!}
              </td>
              <td>
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
              <small style="color:#b0b0b0">Nombre(s)</small>
              </td>
            </tr>

            <tr>
              <td>
              {!! Form::label('last_name', 'Apellido(s):') !!}
              </td>
              <td>
              {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => '' ]) !!}
              <small style="color:#b0b0b0">Apellido(s)</small>
              </td>
            </tr>

            <tr>
              <td>
              {!! Form::label('email', 'Correo:') !!}
              </td>
              <td>
              {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => '', 'readonly' => 'true' ]) !!}
              <small style="color:#b0b0b0">Correo registrado</small>
              </td>
            </tr>

            <tr>
              <td>
              {!! Form::submit('Actualizar Perfil', ['class' => 'btn btn-primary']) !!}
              </td>
              <td>
                <a type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">Cambiar mi contraseña</a>
              </td>
            </tr>
          </table>


          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                <table border="0" style="width: 80%; margin: 0 auto;">
                  <tr>
                    <td style="width:250px">
                    {!! Form::label('password', 'Nueva contraseña:') !!}
                    </td>
                    <td style="width:300px">
                    {!! Form::password('password', null) !!}
                    <small style="color:#b0b0b0">Escribe al menos 8 caracteres</small>
                    </td>
                  </tr>

                  <tr>
                    <td>
                    {!! Form::label('password2', 'Confirmar contraseña:') !!}
                    </td>
                    <td>
                    {!! Form::password('password2', null) !!}
                    <small style="color:#b0b0b0">Las contraseñas deben ser iguales</small>
                    </td>
                  </tr>
                </table>

                <div class="alert alert-warning" role="alert" id="aviso" style="display:none;">
                    <strong>Atención:</strong>{{ session('error_pass') }}
                </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  {!! Form::submit('Actualizar Contraseña', ['class' => 'btn btn-primary']) !!}
                </div>
              </div>
            </div>
          </div>


          {!! Form::close() !!}

          @if(Auth::user()->role_id == 1)
              <button class="btn btn-dark" onclick="deleteConfirmation({{$user->id}})">Eliminar Usuario</button>
          @endif

          <a href="{{ url('home') }}" type="button" class="btn btn-outline-danger" >Regresar</a>

        <!--
          {!! Form::model($user,['method' => 'DELETE', 'action' => ['AdminUsersController@destroy', $user->id]]) !!}
              @if(Auth::user()->role_id == 1)
                {!! Form::submit('Eliminar usuario', ['class' => 'btn btn-dark']) !!}
              @endif
          {!! Form::close() !!}
        -->

      </div>

  </div>

  </div>

</div>

</body>

@endsection
