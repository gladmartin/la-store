<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SEO Tags -->
    <meta name="theme-color" content="{{ safeUndefined($webOption->site_default_color) }}">
    <meta name="msapplication-navbutton-color" content="{{ safeUndefined($webOption->site_default_color) }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{ safeUndefined($webOption->site_default_color) }}">
    <meta name="Language" content="Indonesia" />
    <meta http-equiv="content-language" content="id" />
    @stack('meta')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ safeUndefined($webOption->site_title) }}</title>
    <link rel="alternate" href="{{ url()->current() }}" hreflang="id-ID" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset-bootstrap.css?i=' . time()) }}) }}" rel="stylesheet">
    <link href="{{ asset('css/main.css?i=' . time()) }}" rel="stylesheet">
    <link href="{{ asset('css/main-mobile.css?i=' . time()) }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a6c2ef0f76.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('storage/' . safeUndefined($webOption->logo)) }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="{{ safeUndefined($webOption->site_default_font_url) }}" rel="stylesheet">
    <style>
        :root {
            --main-color: {{safeUndefined($webOption->site_default_color)}};
            --main-color-low: {{safeUndefined($webOption->site_default_color)}};
            /* --main-color-low: rgba(255, 146, 99, 0.301); */
        }
        body {
            font-family: '{{ safeUndefined($webOption->site_default_font_family) }}', sans-serif !important;
        }
    </style>
    @stack('css')
    <link href="{{ asset('css/snackbarlight.min.css') }}" rel="stylesheet">
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
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm d-none d-sm-block">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                <img src="{{ asset('img/logo-store.png') }}" width="100px">
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
                            <a class="nav-link text-white" href="{{ url('shop') }}">{{ __('Belanja') }}</a>
                        </li>
                        <li class="nav-item dropdown d-none">
                            <a id="kategoriDropdown" class="nav-link text-white dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Kategori') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="kategoriDropdown">
                                <a class="dropdown-item" href="{{ url('logout') }}">Tes</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white"
                                href="{{ route('order.konfirmasi') }}">{{ __('Konfirmasi Pembayaran') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('order.lacak') }}">{{ __('Lacak Pesanan') }}</a>
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
        <nav class="bg-white shadow-sm d-block d-sm-none py-2 bg-primary">
            <div class="container">
                <div class="text-center">
                    <a class="navbar-brand text-white font-weight-bold text-center" href="{{ url('/') }}">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img src="{{ asset('img/logo-store.png') }}" alt="LaStore" width="130px">
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
        <div class="d-block d-sm-none nav-bottom-warapper">

            <nav class="nav-bottom d-flex justify-content-around shadow-lg">
                <a href="{{ url('/') }}" class="text-center nav-bottom-item {{ isMenuActive('site.home') }}">
                    <div><i class="fa fa-home"></i></div>
                    <div class="nav-bottom-text max-line-1">Beranda</div>
                </a>
                <a href="{{ url('/shop') }}" class="text-center nav-bottom-item {{ isMenuActive('shop.index') }}">
                    <div><i class="fa fa-shopping-bag"></i></div>
                    <div class="nav-bottom-text max-line-1">Belanja</div>
                </a>
                <a href="{{route('order.konfirmasi')}}" class="text-center nav-bottom-item {{ isMenuActive('order.konfirmasi') }}">
                    <div><i class="fa fa-money-bill"></i></div>
                    <div class="nav-bottom-text max-line-1">Konfirmasi bayar</div>
                </a>
                <a href="{{route('order.lacak')}}" class="text-center nav-bottom-item {{ isMenuActive('order.lacak') }}">
                    <div><i class="fa fa-box"></i></div>
                    <div class="nav-bottom-text max-line-1">Lacak pesanan</div>
                </a>
            </nav>
        </div>

       

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/snackbarlight.min.js') }}"></script>
    <script>
        const BASE_URL = '{{ url("/") }}';
        const BASE_URL_API = '{{ url("api") }}';
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const htmlNavBottom = $('.nav-bottom-warapper').html();
        $(document).on('focus', 'textarea, input', function(e){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
                // alert('taik');
                $('.nav-bottom-warapper').html('')
            }
        });

        $(document).on('blur', 'textarea, input', function(e){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ){
                // alert('taik');
                $('.nav-bottom-warapper').html(htmlNavBottom)
            }
        });
    </script>
     @if (session('info'))
     <script>
         let info = "{{ session('info') }}"
         new Snackbar(info);
     </script>
     @endif
    @stack('js')

</body>

</html>
