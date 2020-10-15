<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Gustavo Decker">
    <title>{{ env('APP_NAME', 'Human Consulting') }}</title>
    <meta name="keyword" content="Software, Consulting, Sistema">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }} "></script>
    <script type="text/javascript" src="{{ asset('/assets/scripts/main.js') }} "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="../../vendor/toastr/toastr.min.js"></script>
    <script src="{{ asset('../daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('../daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('../js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('../js/jquery.inputmask.js')  }}"></script>
    @yield('js')

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('../images/favicon.png') }}" />
    <link href="{{ asset('../main.css') }}" rel="stylesheet"></head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="../../vendor/toastr/toastr.min.css">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('../daterangepicker/daterangepicker.css') }}">
<body>
    <style type="text/css">
        .vertical-nav-menu li a.active {
    background: #3490dc;
    text-decoration: none;
    color: white;
}
#formulario label[tipo="error"]{
   /* margin-left: 45px;
    width: 90%;
    margin-bottom: 0px;*/
    display: none;
    font-size: 12px;
    color: #fe0000;
}
.error{
    border: 1px solid red !important;
}

    </style>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
        </div>
        <div class="app-header__content">
            @if(Auth::user()->role =='aspirante')
            <div class="app-header-left">
                <div class="search-wrapper">
                    <div class="input-holder">
                        <form id="search-form" action="{{ route('search') }}" method="POST" >
                                            {{ csrf_field() }}
                                    <input type="text" class="search-input" id="search" name="search" placeholder="Type to search">
                        </form>
                        <button class="search-icon"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div>
            </div>
            @endif
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" class="rounded-circle" onerror="imgErrora(this);" src="/storage/perfil/{{ Auth::user()->id  }}.jpg?{{ time() }}" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    {{--<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                        <h6 tabindex="-1" class="dropdown-header">Configuración</h6>
                                        <a href="{{route('user.show')}}" tabindex="0" class="dropdown-item">Editar mi perfil</a>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <button type="button" tabindex="0" class="dropdown-item" onclick="document.getElementById('logout-form').submit();">Cerrar Sesión</button>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                    </div>--}}
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="widget-subheading">
                                    {{ Auth::user()->role }}
                                </div>
                            </div>
                            <div class="widget-content-right header-user-info ml-3">
                                &nbsp;
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                         <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   title="Salir" type="button" class="btn-shadow p-1 btn btn-primary">
                                    <i class="fa text-white fa-chevron-circle-right pr-1 pl-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>        </div>
        </div>
    </div>

    <div class="app-main">
        <div class="app-sidebar sidebar-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
            </div>
            <div class="scrollbar-sidebar ps ps--active-y">
                <div class="app-sidebar__inner">
                    <ul class="vertical-nav-menu metismenu">

                        <li class="app-sidebar__heading">MENÚ</li>
                        <li >
                            <a href="{{ route('home')}}" class="{{ Route::is('home') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Dashboard
                            </a>
                        </li>
                         @if(Auth::user()->role=="aspirante")
                        <li >
                            <a href="{{ route('postulaciones')}}" class="{{ Route::is('postulaciones') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Mis Postulaciones
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('aspirante')}}" class="{{ Route::is('aspirante') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Mi Currículum
                            </a>
                        </li>
                        @endif
                        {{--<li class="app-sidebar__heading">CATEGORÍAS</li>
                        @foreach($allCategories as $categorie)
                            <li >
                                <a href="{{ route('home')}}">
                                    <i class="metismenu-icon pe-7s-display2"></i>
                                    {{ $categorie->nombre }}
                                </a>
                            </li>
                            @endforeach--}}
                        @if(Auth::user()->role=="admin" || Auth::user()->role=="empresa")
                        <li >
                            <a href="{{ route('ofertas')}}" class="{{ Route::is('ofertas') || Route::is('ofertas.aspirantes') ? 'active' : '' }}">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Ofertas
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role=="admin")
                        <li>
                           <a href="{{ route('user')}}" class="{{ Route::is('user') ? 'active' : '' }}">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Empresas
                           </a>
                        </li>
                        @endif
                        @if(Auth::user()->role=="admin")
                        <li>
                           <a href="{{ route('categorias')}}" class="{{ Route::is('categorias') ? 'active' : '' }}">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Categorías
                           </a>
                        </li>
                        @endif
                        @if(Auth::user()->role=="admin") {{-- solo el admin la puede administrar --}}
                        <li>
                           <a href="{{ route('habilidades')}}" class="{{ Route::is('habilidades') ? 'active' : '' }}">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Habilidades
                           </a>
                        </li>
                        @endif

                    </ul>
                </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 565px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 472px;"></div></div></div>
        </div>
        <div class="app-main__outer">
            <div class="app-main__inner">
                    @yield('title')


                    @yield('content')

            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">

                        </div>
                        <div class="app-footer-right">
                          Desarrollado por Deckasoft Ecuador - © Copyright 2020
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@yield('modal')
<div id='app'></div>
</body>
<script type="text/javascript">
    function imgErrora(image) {
    image.onerror = "";
    image.src = "/images/avatar.jpg";
    return true;
}
</script>
