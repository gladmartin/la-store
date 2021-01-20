@extends('layouts.admin')

@section('title', 'Pengerimana barang')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengiriman barang</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">List Pengiriman barang</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-server-side">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Invoice</th>
                        <th>Nomor Resi</th>
                        <th>Ekspedisi</th>
                        <th>Service</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
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
        ajax: '{{ route("dt.delivery") }}',
        columns: [
            {
                data: 'order.invoice',
                name: 'order.invoice',
                defaultContent: 'ke'
            },
            {
                data: 'no_resi',
                name: 'no_resi',
                defaultContent: '<span class="badge badge-secondary">Belum diset</span>'
            },
            {
                data: 'ekspedisi',
                name: 'ekspedisi',
            },
            {
                data: 'service',
                name: 'service',
            },
            {
                data: 'address',
                name: 'address',
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'aksi',
                name: 'aksi',
            },
        ],
        order: [
            [5, 'desc']
        ]
    });

</script>
@endpush
