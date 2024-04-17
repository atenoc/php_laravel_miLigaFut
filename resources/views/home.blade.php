
@extends('layouts.app')

@section('content')

    @if (session('alert'))

          <script type="application/javascript">

            var mensaje = ' {{ session('alert') }} ';
            Swal.fire({ icon: 'success', title:'¡Bien!', text: mensaje, showConfirmButton: false, timer: 1900 })

          </script>
          @yield('scripts')

    @endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                  @if($liga)

                      @if($liga->image)
                        <img src="{{ URL::to('/images/' . $liga->image->nombre_imagen) }}" class="redondop"/>
                      @else
                      <img src="{{ URL::to('/images/liga-no-image.png') }}" height="40px"/>
                      @endif

                      <span style="margin-left: 15px;"><strong>  {{ $liga->nombre_liga }}</strong>, </span>

                      @if($liga->sede->nombre_sede)
                        <span>{{ $liga->sede->nombre_sede }}</span>
                      @else <span>- - -</span> @endif

                      @if($liga->temporada->nombre_temporada)
                        <span>{{ $liga->temporada->nombre_temporada }}</span>
                      @else <span>- - -</span> @endif

                  @else
                      ¡¡ Debes agregar una liga para administrarla !!
                      <h5><a href="{{ url('ligas/create') }}" type="button" class="btn btn-primary" style="margin-left: 5px;">Agrega una liga</a></h5>
                  @endif

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <h6><a href="{{ url('ligas') }}" type="button" >Ver Ligas Inscritas</a></h6>
                    @if(Auth::user()->liga->id)
                    <h6><a href="" type="button" class="btn btn-primary" >+ Agregar Equipos</a></h6>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
