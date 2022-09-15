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
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card ">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo usuario') }}</h4>
                            <p class="card-product">{{ __('Registrar un nuevo usuario en el sistema.') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="fileinput fileinput-new text-center">
                                        <div class="fileinput-new thumbnail img-raised">
                                            <div style="height: 230px; border: solid;" id="imagePreview"></div>
                                        </div>
                                        <div>
                                            <span class="btn btn-raised btn-round btn-rose btn-file">
                                                <span class="fileinput-new">Seleccionar logotipo</span>
                                                <span class="fileinput-exists">Cargar</span>
                                                <input type="file"  onchange="return fileValidation()" name="avatar" id="input-avatar" />
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
                                            value="{{ old('nickname') }}" aria-required="true"/>
                                            @if ($errors->has('nickname'))
                                                <span id="nickname-error" class="error text-danger" for="input-nickname">{{ $errors->first('nickname') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('nombre del usuario') }}"
                                            value="{{ old('name') }}" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="text" placeholder="{{ __('correo electrónico') }}"
                                            value="{{ old('email') }}" aria-required="true"/>
                                            @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" id="input-password" type="password"
                                            value="{{ old('password') }}" aria-required="true"/>
                                            @if ($errors->has('password'))
                                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                            name="password_confirmation" id="input-password_confirmation" type="password"
                                            value="{{ old('password_confirmation') }}" aria-required="true"/>
                                            @if ($errors->has('password_confirmation'))
                                                <span id="password_confirmation-error" class="error text-danger" for="input-password_confirmation">{{ $errors->first('password_confirmation') }}</span>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Usuarios') }}</h4>
                        <p class="card-product"> {{ __('En esta pantalla el sistema muestra todas las Usuarios registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get" action="{{ route('user.index') }}" autocomplete="off" class="form-horizontal">
                                    @csrf
                                    @method('get')
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search">
                                        <div class="input-group-append">
                                            <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default pull-right">
                                    Página
                                    <span class="badge badge-light">{{ number_format($items->currentPage(),0,'',',') }}</span>
                                    de
                                    <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                                    registros, mostrados
                                    <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage() * $items->currentPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                                    de un total de
                                    <span class="badge badge-light">{{ number_format($items->total(),0,'',',') }}</span>
                                    registros
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><br><br></div>
                            @foreach ($items as $item)
                                <div class="col-md-3">
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px">
                                        <div class="card-header card-header-image">
                                            <img class="img" src="{{ $item->avatar }}" height="300px;" rel="nofollow">
                                        </div>

                                        <div class="card-body ">
                                            <h4 class="card-title">{{ $item->name }}</h4>
                                            <h5 class="card-title">{{ $item->nickname == null ? 'N/A' : $item->nickname }}</h5>
                                            <h6 class="card-category text-gray">{{ $item->email }}</h6>
                                        </div>

                                        <div class="card-footer justify-content-center">
                                            <form method="post" action="{{ route('user.delete', $item) }}">
                                                @csrf
                                                @method('delete')

                                                @if ($item->current)
                                                    <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Eliminar usuario" type="button" class="btn btn-just-icon btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el usuario {$item->name}?") }}') ? this.parentElement.submit() : ''">
                                                        <i class="material-icons">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                @else
                                                    <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Activar usuario" type="button" class="btn btn-just-icon btn-info btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea activar el usuario {$item->name}?") }}') ? this.parentElement.submit() : ''">
                                                        <i class="material-icons">cached</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                @endif
                                            </form>
                                            <a rel="tooltip" class="btn btn-just-icon btn-warning btn-sm btn-round" href="{{ route('user.edit', $item) }}" data-toggle="tooltip" data-placement="top" title="Editar información">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            @if (!$item->system)
                                                <a rel="tooltip" class="btn btn-just-icon btn-success btn-sm btn-round" href="{{ route('user.system', $item) }}" data-toggle="tooltip" data-placement="top" title="Otorgar acceso al sistema">
                                                    <i class="material-icons">check_circle_outline</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                            @else
                                                <a rel="tooltip" class="btn btn-just-icon btn-danger btn-sm btn-round" href="{{ route('user.system', $item) }}" data-toggle="tooltip" data-placement="top" title="Denegar acceso al sistema">
                                                    <i class="material-icons">highlight_off</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $items->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
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
