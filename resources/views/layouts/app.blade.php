<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('material/img/favicon.png') }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    @include('layouts.page_templates.style')
</head>

<body class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.page_templates.auth')
    @include('layouts.page_templates.fondo')
    @endauth
    @guest()
    @include('layouts.page_templates.guest')
    @endguest
    @include('layouts.page_templates.script')

    <script>
        function fileValidation(){
                var fileInput = document.getElementById('input-logotipo');
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
                    document.getElementById('imagePreview').innerHTML = '';
                    return false;
                }else{
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('imagePreview').innerHTML = '<img class="img" src="'+e.target.result+'"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
    </script>
    @stack('js')
</body>

</html>