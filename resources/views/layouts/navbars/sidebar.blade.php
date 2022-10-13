<div class="sidebar" data-color="orange" data-background-color="dark"
  data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
        <div class="fileinput-new thumbnail">
          <img src="{{ $logotipo }}" width="50%" height="50px" rel="nofollow" alt="...">
        </div>
        <strong>{{ $nombre_empresa }}</strong><br>
        {{ $slogan }}
      </div>
    </a>
  </div>
  <div class="sidebar-wrapper ps-container ps-theme-default">
    <ul class="nav">
      <li class="nav-item {{URL::current() == URL::route('sistema.home') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('sistema.home') }}">
          <i class="material-icons">dashboard</i>
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
                <span class="sidebar-normal"> <i class="material-icons">bookmark</i> {{ __('Marcas DPV') }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('variante.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('variante.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">bookmark</i> {{ __('Variantes DPV') }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('presentacion.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('presentacion.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">bookmark</i> {{ __('Presentaciones DPV') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('variante_presentacion.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('variante_presentacion.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">bookmark</i> {{ __('Variantes y Presentaciones
                  DPV') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('categoria.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('categoria.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">drag_indicator</i> {{ __('Categoría DPV') }}
                </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('brand.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('brand.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">bookmark</i> {{ __('Marcas') }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('category.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('category.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">drag_indicator</i> {{ __('Categoría') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#credits" aria-expanded="true">
          <p>Configuración<b class="caret"></b></p>
        </a>
        <div class="collapse" id="credits">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('catalogo_escuela.index') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('catalogo_escuela.index') }}">
                <span class="sidebar-normal"> <i class="material-icons">card_giftcard</i> {{ __('Catálogo de Escuelas')
                  }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('credit.history') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('credit.history') }}">
                <span class="sidebar-normal"> <i class="material-icons">description</i> {{ __('Historial de créditos')
                  }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{URL::current() == URL::route('producto.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('producto.index') }}">
          <i class="material-icons">store</i>
          <p>{{ __('Producto DPV') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('product.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('product.index') }}">
          <i class="material-icons">store</i>
          <p>{{ __('Producto') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('order.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('order.index') }}">
          <i class="material-icons">shopping_cart</i>
          <p>{{ __('Pedidos') }}</p>
        </a>
      </li>
      <li class="nav-item {{URL::current() == URL::route('user.index') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.index') }}">
          <i class="material-icons">supervisor_account</i>
          <p>{{ __('Usuarios') }}</p>
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
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#systems" aria-expanded="true">
          <p>Configuración<b class="caret"></b></p>
        </a>
        <div class="collapse" id="systems">
          <ul class="nav">
            <li class="nav-item {{URL::current() == URL::route('company.index_sistema') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('company.index_sistema') }}">
                <span class="sidebar-normal"> <i class="material-icons">phonelink</i> {{ __('Sistema WEB') }} </span>
              </a>
            </li>
            <li class="nav-item {{URL::current() == URL::route('company.index_pagina') ? 'active' : ''}}">
              <a class="nav-link" href="{{ route('company.index_pagina') }}">
                <span class="sidebar-normal"> <i class="material-icons">phonelink</i> {{ __('Página WEB') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>