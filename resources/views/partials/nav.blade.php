    <li class="nav-header" style="background-color:white !important;" >
        <div class="dropdown profile-element" style="ackground-bcolor:white !important;">
            @auth
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

            @if(verificarempresaloginicon())
                        <span class="block m-t-xs font-bold">  <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" alt="" width="40">{{" ".auth()->user()->usuario}}</span>
                        @else

                          <span class="block m-t-xs font-bold">  <img src="{{asset('img/e.png')}}" alt="" width="40">{{" ".auth()->user()->usuario}}</span>
                        @endif


            @endauth
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a class="dropdown-item" href="{{route('logout')}}">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="logo-element">
        @if(verificarempresaloginicon())
            <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" height="45" width="45">
        @else
            <img src="{{asset('img/e.png')}}" height="45" width="45">
        @endif

        </div>
    </li>
    <li>
        <a href="{{route('mapa.index')}}"><i class="fa fa-th-large" style="color:rgb(37, 36, 64)!important;"></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">MAPAS</span></a>
    </li>
    @can('haveaccess','modulo.gps')
    <li class="@yield('gps-active')">
        <a href="#"><i class="fa fa-shopping-cart" style="color:rgb(37, 36, 64)!important;"></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">GPS</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse" >
            <li class="@yield('clientes-active')"><a  style="color:rgb(37, 36, 64)!important;" href="{{ route('cliente.index') }}">Clientes</a></li>
            <li class="@yield('empresas-active')"><a href="{{ route('empresas.index')}}">Empresas</a></li>
            <li class="@yield('tipodispositivo-active')"><a href="{{ route('tipodispositivo.index')}}">Tipos Dispositivos</a></li>
            <li class="@yield('dispositivo-active')"><a href="{{ route('dispositivo.index')}}">Dispositivos</a></li>
            <li class="@yield('contrato-active')"><a href="{{ route('contrato.index')}}">Contratos</a></li>
            <li class="@yield('reportesmovimiento-active')"><a href="{{ route('reportes.index')}}">Reporte de Movimiento</a></li>
            <li class="@yield('reportesgeozona-active')"><a href="{{ route('reportes.geozona')}}">Reporte de Geozona</a></li>
            <li class="@yield('reportesgeozonasalida-active')"><a href="{{ route('reportes.geozonasalida')}}">Reporte de Salida</a></li>
            <li class="@yield('reportesgeozonagrupo-active')"><a href="{{ route('reportes.geozonagrupo')}}">Reporte de grupo</a></li>
            <li class="@yield('reportesalerta-active')"><a href="{{ route('reportes.alerta')}}">Reporte de Alertas</a></li>
            <li class="@yield('rangos-active')"><a href="{{ route('rangos.index')}}">Rangos</a></li>
        </ul>
    </li>
    @endcan
    @can('haveaccess','modulo.mantenimiento')
    <li class="@yield('mantenimiento-active')">
        <a href="#"><i class="fa fa-shopping-cart" style="color:rgb(37, 36, 64)!important;" ></i> <span class="nav-label" style="color:rgb(37, 36, 64)!important;">Mantenimiento</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="@yield('tablas-active')"><a href="{{route('mantenimiento.tabla.general.index')}}">Tablas Generales</a></li>
            <li class="@yield('colaboradores-active')"><a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a></li>
            <li class="@yield('empresa-active')"><a href="{{ route('empresa.index')}}">Empresa Personal</a></li>
            <li class="@yield('mensaje-active')"><a href="{{ route('mensaje.index')}}">Mensaje Personalizado</a></li>
            <li class="@yield('roles-active')"><a href="{{ route('roles.index')}}">Roles</a></li>
            <li class="@yield('usuarios-active')"><a href="{{ route('usuarios.index')}}">Usuario</a></li>
        </ul>
    </li>
    @endcan

