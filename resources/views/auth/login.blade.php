@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Nombre Sistema')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Inicio de sesión') }}</strong></h4>
            <div class="social-line">
              <a href="{{ $page }}" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-laptop"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="bmd-form-group{{ $errors->has('usuario') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" name="usuario" class="form-control" placeholder="{{ __('usuario') }}"
                  value="{{ old('usuario') }}" required>
              </div>
              @if ($errors->has('usuario'))
              <div id="usuario-error" class="error text-danger pl-3" for="usuario" style="display: block;">
                <strong>{{ $errors->first('usuario') }}</strong>
              </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control"
                  placeholder="{{ __('Password...') }}" value="{{ !$errors->has('password') ? " secret" : "" }}"
                  required>
              </div>
              @if ($errors->has('password'))
              <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
              @endif
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Entrar') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection