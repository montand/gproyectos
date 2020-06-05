<nav class="navbar navbar-light navbar-expand-lg bg-white shadow-sm">
   <div class="container">
      {{-- <i class="fas fa-home fa-2x">&nbsp</i> --}}
      <img src="{{ url('img/left.png') }}" style="width: 40px" alt="">
      <a class="navbar-brand"
         href="{{ url('/') }}">
         {{ config('app.name', 'SGP_AS14') }}
      </a>
      <button class="navbar-toggler" type="button"
         data-toggle="collapse"
         data-target="#navbarSupportedContent"
         aria-controls="navbarSupportedContent"
         aria-expanded="false"
         aria-label="{{ __('Toggle navigation') }}">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         @auth
            <ul class="nav nav-pills">
               @if( auth()->user()->hasAnyPermission('leer elementos',
                  'leer criterios','leer temas','leer proyectos','leer periodos'))
               <li class="nav-item dropdown">
                  <a id="catalogosDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Catálogos
                  </a>
                  <div class="dropdown-menu dropdown-menu-left" aria-labelledby="catalogosDropdown">
                     @can('leer elementos')
                     <a class="dropdown-item" href="{{ route('elementos.index') }}">
                        Elementos
                     </a>
                     @endcan
                     @can('leer criterios')
                     <a class="dropdown-item" href="{{ route('criterios.index') }}">
                        Criterios
                     </a>
                     @endcan
                     @can('leer temas')
                     <a class="dropdown-item" href="{{ route('temas.index') }}">
                        Temas
                     </a>
                     @endcan
                     @can('leer proyectos')
                     <a class="dropdown-item" href="{{ route('proyectos.index') }}">
                        Proyectos
                     </a>
                     @endcan
                     @can('leer periodos')
                     <a class="dropdown-item" href="{{ route('periodos.index') }}">
                        Periodos
                     </a>
                     @endcan
                  </div>
               </li>
               @endif
               @if( auth()->user()->hasPermissionTo('leer escenarios'))
               <li class="nav-item dropdown">
                  <a id="capturaDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Captura
                  </a>
                  <div class="dropdown-menu dropdown-menu-left" aria-labelledby="capturaDropdown">
                     @can('leer escenarios')
                     <a class="dropdown-item" href="{{ route('escenarios.index') }}">
                        Escenarios
                     </a>
                     @endcan
{{--                      <a class="dropdown-item" href="{{ route('pmaestro.index') }}">
                        Plan Maestro
                     </a> --}}
                  </div>
               </li>
               @endif
               @if( auth()->user()->hasAnyPermission('leer configuracion','leer usuarios'))
               <li class="nav-item dropdown">
                  <a id="configDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Administración
                  </a>
                  <div class="dropdown-menu dropdown-menu-left" aria-labelledby="configDropdown">
                     @can('leer configuracion')
                        <a class="dropdown-item" href="{{ route('configuracion.index') }}">
                           Configuración
                        </a>
                     @endcan
                     @can('leer usuarios')
                        <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                           Usuarios
                        </a>
                     @endcan
                     @can('leer roles')
                        <a class="dropdown-item" href="{{ route('roles.index') }}">
                           Roles
                        </a>
                     @endcan
                     @can('leer permisos')
                        <a class="dropdown-item" href="{{ route('permissions.index') }}">
                           Permisos
                        </a>
                     @endcan
                  </div>
               </li>
               @endif
            </ul>
         @endauth


         <!-- Right Side Of Navbar -->
         <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @if (session()->has('glo_periodo'))
               <li class="nav-item">
                  <a class="nav-link font-weight-bolder">
                     <i class="fas fa-calendar">&nbsp</i>{{ session('glo_periodo') }}</a>
               </li>
            @endif
            @guest
               <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-door-closed"></i> {{ __('Login') }}</a>
               </li>
               @if (Route::has('register'))
                  <li class="nav-item">
                     <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
               @endif
               @else
               <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     <i class="fas fa-user-alt">&nbsp</i>
                     {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt">&nbsp</i>
                        {{ __('Logout') }}
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                  </div>
               </li>
            @endguest
         </ul>
      </div>
   </div>
</nav>
