<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset-bootstrap.css?i=' . time()) }}) }}" rel="stylesheet">
    <link href="{{ asset('css/main.css?i=' . time()) }}" rel="stylesheet">
    <link href="{{ asset('css/main-mobile.css?i=' . time()) }}" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <style>
        .top-bar-header-menu {
            background: #F7F7F7;
            color: #5e5e5e !important;
            font-weight: bold;
        }

        .main-footer {
            /* background: #F7F7F7; */
            background: white;
            color: #5e5e5e;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .end-footer {
            /* background: #eceaea; */
            font-weight: 300;
            font-size: 11px;
            padding: 10px;
        }

        .link-footer a {
            text-decoration: none;
            color: #b9b8b8;
        }

        a {
            text-decoration: none !important;
            color: #a5a4a4;
        }

        a:hover {
            color: rgb(230, 81, 11);
        }

        .category__box img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

    </style>
    @stack('css')
</head>

<body>
    <div id="app">
        {{-- top bar --}}
        {{-- <div class="top-bar-header-menu text-right mb-0">
            <div class="container">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item py-2">
                        Wa 082298992314
                    </li>
                </ul>
            </div>
        </div> --}}
        {{-- end top bar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm d-none d-sm-block">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler hidden-xs" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('shop') }}">{{ __('Belanja') }}</a>
                        </li>
                        <li class="nav-item dropdown d-none">
                            <a id="kategoriDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Kategori') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="kategoriDropdown">
                                <a class="dropdown-item" href="{{ url('logout') }}">Tes</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('order.konfirmasi') }}">{{ __('Konfirmasi Pembayaran') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.lacak') }}">{{ __('Lacak Pesanan') }}</a>
                        </li>

                        <!-- Authentication Links -->
                        @guest

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produk apa.."
                                aria-label="Cari produk apa.." aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        {{-- nav mobile --}}
        <nav class="bg-white shadow-sm d-block d-sm-none py-2">
            <div class="container">
                <div class="text-center">
                    <a class="navbar-brand font-weight-bold text-center" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <form method="get" class="form-search" action="/shop">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari produk apa.."
                            aria-label="Cari produk apa.." aria-describedby="button-addon2" name="q">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </nav>

        <main class="pb-4">
            @yield('content')
        </main>
        <footer>
            <div class="main-footer border-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 mb-4 col-6">
                            <h5 class="font-weight-bolder">Tentang kami</h5>
                            <div class="link-footer">
                                <a href="" class="d-block">Toko kami</a>
                                <a href="" class="d-block">Kontak</a>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4 col-6">
                            <h5 class="font-weight-bolder">Customer support</h5>
                            <div class="link-footer">
                                <a href="" class="d-block">Toko kami</a>
                                <a href="" class="d-block">Kontak</a>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4 col-12 center-mobile">
                            <h5 class="p-0 m-0 font-weight-bolder">Metode pembayaran</h5>
                            <div class="peyment-box">
                                <img src="https://317927-1222945-1-raikfcquaxqncofqfm.stackpathdns.com/wp-content/uploads/2020/05/Partner-LogoArtboard-1-copy-1-1024x488.png"
                                    alt="" width="100%" class="rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="end-footer border-top">
                <div class="container">
                    <div class="center-mobile">&copy; {{ date('Y') }} Hak Cipta Dilindungi {{ config('app.name') }}
                    </div>
                </div>
            </div>
        </footer>
        <div class="pt-xs-10"></div>
        {{-- button nav mobile --}}
        <div class="d-block d-sm-none">

            <nav class="nav-bottom d-flex justify-content-around shadow-lg">
                <a href="{{ url('/') }}" class="text-center nav-bottom-item">
                    <div><i class="fa fa-home"></i></div>
                    <div class="nav-bottom-text">Beranda</div>
                </a>
                <a href="{{ url('/shop') }}" class="text-center nav-bottom-item">
                    <div><i class="fa fa-shopping-bag"></i></div>
                    <div class="nav-bottom-text">Belanja</div>
                </a>
                <a href="{{route('order.konfirmasi')}}" class="text-center nav-bottom-item">
                    <div><i class="fa fa-money-bill"></i></div>
                    <div class="nav-bottom-text">Konfirmasi bayar</div>
                </a>
                <a href="{{route('order.lacak')}}" class="text-center nav-bottom-item">
                    <div><i class="fa fa-box"></i></div>
                    <div class="nav-bottom-text">Lacak pesanan</div>
                </a>
            </nav>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        const BASE_URL = '{{ url("/") }}';
        const BASE_URL_API = '{{ url("api") }}';
        const CSRF_TOKEN = '{{ csrf_token() }}';

    </script>
    @stack('js')

</body>

</html>
