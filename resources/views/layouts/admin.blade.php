<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('/favicon.png') }}" type="image/x-icon">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/snackbarlight.min.css') }}" rel="stylesheet">
    <style>
        a:hover {
            text-decoration: none;
        }

    </style>
    @stack('css')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}"
                target="blank">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="fas fa-fw fa-store"></i>
                    <span>Produk</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('scrape-mp.index') }}">
                    <i class="fas fa-fw fa-store"></i>
                    <span>Scrape produk</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('order.index') }}">
                    <i class="fas fa-fw fa-shopping-bag"></i>
                    <span>Order</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('delivery.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Delivery</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('post.index') }}">
                    <i class="fas fa-fw fa-blog"></i>
                    <span>Post</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('setting.web') }}">Umum</a>
                        <a class="collapse-item" href="{{ route('setting.bank') }}">Akun Bank</a>
                        <a class="collapse-item" href="{{ route('setting.footer') }}">Widget footer</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('account.index') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Akun anda</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('blacklist.index') }}">
                    <i class="fas fa-fw fa-ban"></i>
                    <span>Blacklist word</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('shortcode.index') }}">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Shortcode</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('log.index') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Log Jobs</span></a>
            </li>

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }} </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    {{-- <script src=""></script> --}}
    {{-- <script src=""></script> --}}
    {{-- <script src=""></script> --}}


    <script src="{{ asset('js/snackbarlight.min.js') }}"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

    <script>
        const el = document.querySelectorAll('img');
        const observer = lozad(el); 
        observer.observe();
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const BASE_URL = '{{ url("/") }}';
        const BASE_URL_API = '{{ url("api") }}';
        const BASE_URL_ADMIN = '{{ url("/app-panel") }}';
        $(document).ready(function () {
            $('.datatable').DataTable();
        });

    </script>
    @if (session('info'))
    <script>
        let info = "{{ session('info') }}"
        new Snackbar(info);

    </script>
    @endif

    <script>

        $('body').on('click', '.btn-delete', function(e) {
            return confirm('Apakah anda yakin? data akan dihapus permanen!');
        });

        $('.parent-check').on('click', function(e) {
            if($(this).is(':checked',true)) {
                $('.row-check').prop('checked', true);  
            } else {  
                $('.row-check').prop('checked',false);  
            }  
            countCheckd()
        });

        $('body').on('click', '.row-check', function() {
            countCheckd();
        });

        function clearCheckd() {
            $('.parent-check').prop('checked', false);
            $('.row-check').prop('checked', false);  
        }

        function countCheckd() {
            let checked = $('.row-check:checked').length;
            if (checked <= 0) {
                $('.header-action').hide();
                return;
            }
            $('.btn-delete-bulk').html(`Hapus ${checked} data`);
            $('.header-action').show();
        }

        async function sendDeleteBulk(endpoint, ids) {
            let raw = await fetch(endpoint, {
                method: 'delete',
                headers : {
                    'accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ids
                })
            });

            let res = await raw.json();

            return res;
        }

    </script>

    @stack('js')

    <script>
        $('.btn-delete-bulk').on('click', async function(e) {
            e.preventDefault();
            let endpoint = $(this).data('endpoint');
            if (!endpoint) return false;
            if (!confirm('Apakah anda yakin? data akan dihapus permanen!')) {
                return false;
            }
            let ids = [];
            let checked = $('.row-check:checked');
            checked.each(function() {
                let id = $(this).data('id');
                ids.push(id);
            });

            if (ids.length <= 0) {
                alert('Pilih checkbox yang mau dihpaus dulu.');
                return false;
            }
            $('.btn-delete-bulk').html('Sedang memproses...');
            let hasil = await sendDeleteBulk(endpoint, ids);
            await table.ajax.reload();
            clearCheckd();
            countCheckd();

            if (!hasil.success) {
                alert('Tidak dapat menghapus data!');
                return false;
            }
        });
    </script>

</body>

</html>
