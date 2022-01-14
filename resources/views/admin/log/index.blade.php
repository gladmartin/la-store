@extends('layouts.admin')

@section('title', 'Daftar Log')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Log</h1>
    <a href="{{ route('log.clear') }}" class="btn btn-sm btn-danger shadow-sm"><i
            class="fas fa-trash fa-sm text-white-50"></i> Hapus Log</a>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Log Update</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <div class="alert alert-info">
                <b>Info!</b> semua log dalam 30 hari akan dihapus otomatis.
            </div>
            <table class="table datatable-server-side">
                <thead>
                    <tr class="header-action" style="display: none">
                        <td colspan="8">
                        <a href="" class="btn btn-danger btn-sm btn-shadow btn-delete-bulk" data-endpoint="{{ route('blacklist.delete-bulk') }}"></a>
                        </td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <th width="100">Date</th>
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
        ajax: '{{ route("dt.log") }}',
        columns: [
            {
                data: 'message',
                name: 'message',
                orderable: false,
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
        ],
        order: [
            [1, 'desc']
        ]
    });

</script>
@endpush
