@extends('layouts.app')
@section('title', 'Productos')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Productos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Información del producto
                                {{ $product->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-nav-tabs">
                        <div class="card-header card-header-{{ $product->current ? 'success' : 'danger' }}">
                            <h2>{{ $product->getNameCompleteAttribute() }}</h2>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>{{ $product->description }}</p>
                                <footer class="blockquote-footer">Fecha de ingreso <cite
                                        title="Source Title">{{ $product->getFormatoFechaAttribute() }}</cite></footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <button type="button" class="btn btn-block btn-info">{{ $product->getCategoryAttribute() }}</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-block btn-info">{{ $product->getBrandAttribute() }}</button>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <form method="post" action="{{ route('image.store', $product) }}" autocomplete="off"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card ">
                                    <div class="card-header card-header-success">
                                        <h4 class="card-title">{{ __('Nueva imagen') }}</h4>
                                        <p class="card-category">
                                            {{ __("Agregar una nueva imagen al producto {$product->getNameCompleteAttribute()}") }}
                                        </p>
                                    </div>
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="fileinput fileinput-new text-center">
                                                    <div class="fileinput-new thumbnail img-raised text-center">
                                                        <div style="height: 300px; width: 450px; border: solid;" id="imagePreview"></div>
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-raised btn-round btn-rose btn-file">
                                                            <span class="fileinput-new">Seleccionar imagen</span>
                                                            <span class="fileinput-exists">Cargar</span>
                                                            <input type="file" onchange="return fileValidation()"
                                                                name="photo" id="input-photo" />
                                                        </span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('photo'))
                                                    <span id="photo-error" class="error text-danger"
                                                        for="input-photo">{{ $errors->first('photo') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ml-auto mr-auto">
                                        <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                            href="{{ route('product.show', $product) }}" data-toggle="tooltip"
                                            data-placement="top" title="Cancelar">
                                            <i class="material-icons">block</i> Cancelar
                                            <div class="ripple-container"></div>
                                        </a>
                                        <button rel="tooltip" type="submit" class="btn btn-flat btn-md btn-success"
                                            data-toggle="tooltip" data-placement="top" title="Guardar información">
                                            <i class="material-icons">add_box</i> Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 ml-auto mr-auto">
                                    <div class="card card-pricing bg-info">
                                        <div class="card-body ">
                                            <div class="card-icon"><i class="material-icons">account_balance_wallet</i>
                                            </div>
                                            <h3 class="card-title">{{ $product->getStringPriceAttribute() }}</h3>
                                            <p class="card-description">
                                                Precio del producto.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ml-auto mr-auto">
                                    <div class="card card-pricing bg-info">
                                        <div class="card-body ">
                                            <div class="card-icon"><i class="material-icons">notification_important</i>
                                            </div>
                                            <h3 class="card-title">{{ number_format($product->discount, 2, '.', ',') }}%
                                            </h3>
                                            <p class="card-description">
                                                Descuento del producto.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ml-auto mr-auto">
                                    <div class="card card-pricing bg-info">
                                        <div class="card-body ">
                                            <div class="card-icon"><i class="material-icons">storefront</i></div>
                                            <h3 class="card-title">{{ number_format($product->stock, 0, '', ',') }}</h3>
                                            <p class="card-description">
                                                Existencia en el inventario.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($images as $item)
                    <div class="col-md-4">
                        <div class="card-header-image" style="height: 450px;">
                            <img class="img" src="{{ $item->photo }}" width="100%" height="100%" rel="nofollow">
                        </div>
                        <form method="post" action="{{ route('image.delete', $item) }}">
                            @csrf
                            @method('delete')
                            <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Eliminar información"
                                type="button" class="btn btn-danger btn-sm btn-round"
                                onclick="confirm('{{ __("¿Está seguro que desea eliminar la imagen del producto {$product->title} ?") }}') ? this.parentElement.submit() : ''">
                                <i class="material-icons">close</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-category card-category-social">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-end">
                                        {{ $images->links() }}
                                    </ul>
                                </nav>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fileValidation() {
            var fileInput = document.getElementById('input-photo');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            if (!allowedExtensions.exec(filePath)) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Solo se permiten imagenes en formato .jpeg/.jpg/.png',
                })
                fileInput.value = '';
                return false;
            } else {
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').innerHTML = '<img width="100%" height="100%" src="' + e
                            .target.result + '"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }

    </script>
@endsection
