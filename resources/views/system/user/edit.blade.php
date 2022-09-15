@extends('layouts.app')
@section('title', 'Usuarios')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('user.update', $user) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar usuario') }}</h4>
                            <p class="card-category">{{ __('Modificar el usuario con nombre ') }} <strong>{{ $user->name }}</strong></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="fileinput fileinput-new text-center">
                                        <div class="fileinput-new thumbnail img-raised">
                                            @if($user->avatar)
                                                <div style="height: 230px; border: solid;" id="imagePreview"><img width="100%" height="100%" src="{{ $user->avatar }}"/></div>
                                            @else
                                                <div style="height: 230px; border: solid;" id="imagePreview"></div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-raised btn-round btn-rose btn-file">
                                                <span class="fileinput-new">Seleccionar logotipo</span>
                                                <span class="fileinput-exists">Cargar</span>
                                                <input type="file" onchange="return fileValidation()" name="avatar" id="input-avatar" />
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span id="avatar-error" class="error text-danger" for="input-avatar">{{ $errors->first('avatar') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group{{ $errors->has('nickname') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}"
                                            name="nickname" id="input-nickname" type="text" placeholder="{{ __('usuario') }}"
                                            value="{{ old('nickname',$user->nickname) }}" aria-required="true"/>
                                            @if ($errors->has('nickname'))
                                                <span id="nickname-error" class="error text-danger" for="input-nickname">{{ $errors->first('nickname') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('nombre del usuario') }}"
                                            value="{{ old('name',$user->name) }}" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="text" placeholder="{{ __('correo electrónico') }}"
                                            value="{{ old('email',$user->email) }}" aria-required="true"/>
                                            @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('user.index') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">block</i> Cancelar
                                <div class="ripple-container"></div>
                            </a>
                            <button rel="tooltip"  type="submit" class="btn btn-flat btn-md btn-success" data-toggle="tooltip" data-placement="top" title="Guardar información">
                                <i class="material-icons">add_box</i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <script>
    function fileValidation(){
        var fileInput = document.getElementById('input-avatar');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
        if(!allowedExtensions.exec(filePath))
        {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Solo se permiten imagenes en formato .jpeg/.jpg/.png',
            })
            fileInput.value = '';
            return false;
        }else{
            //Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img width="100%" height="100%" src="'+e.target.result+'"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    }
  </script>
@endsection
