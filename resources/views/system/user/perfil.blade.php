@extends('layouts.app')
@section('title', 'Perfil')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-{{ $user->current ? 'success' : 'danger' }}">
                      <h2>{{ $user->name }}</h2>
                    </div>
                    <div class="card-body">
                      <blockquote class="blockquote mb-0">
                        <header class="blockquote-footer">Fecha de ingreso <cite title="Source Title">{{ $user->getFormatoFechaAttribute() }}</cite></header>
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                <img src="{{ $user->avatar }}" width="25%" height="25%" rel="nofollow" alt="...">
                            </div>
                        </div>
                        <p class="text-center">{{ $user->nickname }}</p>
                        <p class="text-center">{{ $user->email }}</p>
                      </blockquote>
                      <br><br>
                      <form class="form" method="POST" action="{{ route('user.password_reset', $user) }}">

                        @csrf
                        @method('PUT')

                        <div class="card card-login card-hidden mb-3">
                          <div class="card-header card-header-primary text-center">
                            <h4 class="card-title"><strong>{{ __('Cambio de contraseña') }}</strong></h4>
                          </div>
                          <div class="card-body ">
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">lock_outline</i>
                                  </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}">
                              </div>
                              @if ($errors->has('password'))
                                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                  <strong>{{ $errors->first('password') }}</strong>
                                </div>
                              @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">lock_outline</i>
                                  </span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password...') }}">
                              </div>
                              @if ($errors->has('password_confirmation'))
                                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </div>
                              @endif
                            </div>
                          </div>
                          <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-success btn-md">{{ __('Cambiar') }}</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ml-auto mr-auto">
                <div class="card card-pricing bg-info">
                    <div class="card-body ">
                        <div class="card-icon"><i class="material-icons">stars</i></div>
                        <h3 class="card-title">{{ number_format($pedidos_count,0,'',',') }}</h3>
                        <p class="card-description">
                            Pedidos realizados.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ml-auto mr-auto">
                <div class="card card-pricing bg-info">
                    <div class="card-body ">
                        <div class="card-icon"><i class="material-icons">stars</i></div>
                        <h3 class="card-title">{{ number_format($procesos_count,0,'',',') }}</h3>
                        <p class="card-description">
                            Pedidos en proceso.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ml-auto mr-auto">
                <div class="card card-pricing bg-info">
                    <div class="card-body ">
                        <div class="card-icon"><i class="material-icons">stars</i></div>
                        <h3 class="card-title">{{ number_format($entregados_count,0,'',',') }}</h3>
                        <p class="card-description">
                            Pedidos entregados.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ml-auto mr-auto">
                <div class="card card-pricing bg-info">
                    <div class="card-body ">
                        <div class="card-icon"><i class="material-icons">stars</i></div>
                        <h3 class="card-title">{{ number_format($anulados_count,0,'',',') }}</h3>
                        <p class="card-description">
                            Pedidos anulados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
