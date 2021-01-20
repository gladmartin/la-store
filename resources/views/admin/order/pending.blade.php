@extends('layouts.admin')

@section('title', 'Daftar orderan masuk')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Order</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar orderan</h6>
        <div class="dropdown no-arrow d-none">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
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
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
              <a class="nav-link" href="/all">Semua orderan</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="/pending">Menuggu dikonfirmasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sedang dikirim</a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Orderan selesai</a>
            </li>
          </ul>
        <div class="table-responsive">
            <table class="table datatable-server-side">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Produk yang dibeli</th>
                        <th width="100">Aksi</th>
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
        ajax: '{{ route("dt.order.all") }}',
        columns: [
            {
                data: 'invoice',
                name: 'invoice',
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'product',
                name: 'product',
            },
            {
                data: 'aksi',
                name: 'aksi',
            },
        ],
        order: [
            [1, 'desc']
        ]
    });

</script>
@endpush
