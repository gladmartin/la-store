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
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        @include('admin.order.include.tab')
        <div class="table-responsive">
            <table class="table datatable-server-side">
                <thead>
                    <tr class="header-action" style="display: none">
                        <td colspan="8">
                        <a href="" class="btn btn-danger btn-sm btn-shadow btn-delete-bulk" data-endpoint="{{ route('order.delete-bulk') }}"></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <input type="checkbox" class="parent-check">
                        </th>
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
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        ajax: '{{ route("dt.order", request("show")) }}',
        buttons: [
            'excel', 'pdf', 'print'
        ],
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
            },
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
                orderable: false
            },
        ],
        order: [
            [1, 'desc']
        ]
    });

</script>
@endpush
