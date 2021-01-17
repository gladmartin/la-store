@extends('layouts.admin')

@section('title', 'Daftar produk')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
    <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah produk</a>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar produk anda</h6>
            <div class="dropdown no-arrow d-none">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datatable-server-side">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Produk</td>
                            <td>Stok</td>
                            <td>Terjual</td>
                            <td>Sumber</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    
@endsection

@push('js')
    <script>
        let elementTable = $('.datatable-server-side');
        let table = elementTable.DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("dt.product") }}',
            columns: [
                { data: null, sortable: false, render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'title', name: 'title'},
                { data: 'stok', name: 'stok'},
                { data: 'terjual', name: 'terjual'},
                { data: 'url_sumber', name: 'url_sumber'},
                { data: 'aksi', name: 'aksi'},
            ]
        });
    </script>
@endpush