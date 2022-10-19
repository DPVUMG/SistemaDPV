<div class="sidebar ps" data-color="orange" data-background-color="black"
  data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('sistema.home') }}" class="simple-text logo-normal">
      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
        <div class="fileinput-new thumbnail">
          <img src="{{ $logotipo }}" width="50%" height="50px" rel="nofollow" alt="logo">
        </div>
        <strong>{{ $nombre_empresa }}</strong><br>
        {{ $slogan }}
      </div>
    </a>
  </div>
  <div class="sidebar-wrapper ps">
    <br>
    <div class="user text-center">
      <div class="photo">
        <img src="{{ Auth::user()->getPictureAttribute() }}" class="img img-circle" width="10%">
      </div>
      <div class="user-info">
        <a data-toggle="collapse" href="#collapseExample" class="username collapsed" aria-expanded="false">
          <small>
            {{ Auth::user()->getNameCompleteAttribute() }}
            <b class="caret"></b>
          </small>
        </a>
        <div class="collapse" id="collapseExample">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('usuario.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('usuario.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/usuario_sistema.png') }}" width="20px"
                      alt="Usuario del Sistema">
                  </i>
                  {{ __('Usuario del Sistema') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('configuracion.index_sistema') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('configuracion.index_sistema') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/sistema_web.png') }}" width="20px" alt="Sistema WEB">
                  </i>
                  {{ __('Sistema WEB') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('configuracion.index_pagina') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('configuracion.index_pagina') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/pagina_web.png') }}" width="20px" alt="Página WEB">
                  </i>
                  {{ __('Página WEB') }}
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <hr>
    <ul class="nav">
      <li class="nav-item {{URL::current() == URL::route('sistema.home') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('sistema.home') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/dashboard.png') }}" width="40px" alt="Dashboard">
          </i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#catalogos" aria-expanded="true">
          <p>Catálogos<b class="caret"></b></p>
        </a>
        <div class="collapse" id="catalogos">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('marca.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('marca.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/marca.png') }}" width="20px" alt="Marcas">
                  </i>
                  {{ __('Marcas') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('variante.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('variante.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/variante.png') }}" width="20px" alt="Variantes">
                  </i>
                  {{ __('Variantes') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('presentacion.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('presentacion.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/presentacion.png') }}" width="20px" alt="Presentaciones">
                  </i>
                  {{ __('Presentaciones') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('variante_presentacion.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('variante_presentacion.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/variante_presentacion.png') }}" width="20px"
                      alt="Variantes y Presentaciones">
                  </i>
                  {{ __('Variantes y Presentaciones') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('categoria.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('categoria.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/categoria.png') }}" width="20px" alt="Categoría">
                  </i>
                  {{ __('Categoría') }}
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#credits" aria-expanded="true">
          <p>Configuración de Escuelas<b class="caret"></b></p>
        </a>
        <div class="collapse" id="credits">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('catalogo_escuela.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('catalogo_escuela.index') }}"><span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/catalogo.png') }}" width="20px"
                      alt="Catálogo de Escuelas">
                  </i>
                  {{ __('Catálogo de Escuelas') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('escuela_usuario.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('escuela_usuario.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/usuario_escuela.png') }}" width="20px"
                      alt="Usuario de la Escuela">
                  </i>
                  {{ __('Usuario de la Escuela') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('director.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('director.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/director.png') }}" width="20px" alt="Directores">
                  </i>
                  {{ __('Directores') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('contacto.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('contacto.index') }}">
                <span class="sidebar-normal">
                  <i class="material-icons">
                    <img class="img" src="{{ asset('image/menu/contacto.png') }}" width="20px" alt="Contactos">
                  </i>
                  {{ __('Contactos') }}
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{URL::current() == URL::route('producto.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('producto.index') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/producto.png') }}" width="40px" alt="Producto">
          </i>
          <p>{{ __('Producto') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('escuela.create') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('escuela.create') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/nueva_escuela.png') }}" width="40px" alt="Crear Escuela">
          </i>
          <p>{{ __('Crear Escuela') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('escuela.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('escuela.index') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/escuela.png') }}" width="40px" alt="Escuelas">
          </i>
          <p>{{ __('Escuelas') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('escuela_pedido.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('escuela_pedido.index') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/pedido.png') }}" width="40px" alt="Pedidos">
          </i>
          <p>{{ __('Pedidos') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('escuela_descuento.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('escuela_descuento.index') }}">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/descuento.png') }}" width="40px" alt="Descuentos">
          </i>
          <p>{{ __('Descuentos') }}</p>
        </a>
      </li>
      @if (Auth::user()->admin)
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#reportes" aria-expanded="true">
          <p>Reportes<b class="caret"></b></p>
        </a>
        <div class="collapse" id="reportes">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('report.traicing') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('report.traicing') }}">
                <span class="sidebar-normal"> <i class="material-icons">insert_drive_file</i> {{ __('Información de
                  pedido') }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('report.credit') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('report.credit') }}">
                <span class="sidebar-normal"> <i class="material-icons">insert_drive_file</i> {{ __('Crédito por pagar')
                  }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('report.client') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('report.client') }}">
                <span class="sidebar-normal"> <i class="material-icons">insert_drive_file</i> {{ __('Información del
                  cliente') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endif
      <hr>
      <li class="nav-item {{URL::current() == URL::route('logout') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons">
            <img class="img" src="{{ asset('image/menu/salir.png') }}" width="40px" alt="Cerrar Sesión">
          </i>
          <p>{{ __('Cerrar Sesión') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>