@extends('layouts.admin')

@section('title', 'Daftar postingan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Postingan</h1>
    <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Postingan</a>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Postingan</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-server-side">
                <thead>
                    <tr class="header-action" style="display: none">
                        <td colspan="8">
                        <a href="" class="btn btn-danger btn-sm btn-shadow btn-delete-bulk" data-endpoint="{{ route('post.delete-bulk') }}"></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <input type="checkbox" class="parent-check">
                        </th>
                        <th>Judul</th>
                        <th>Image</th>
                        <th>Tanggal post</th>
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
        ajax: '{{ route("dt.post") }}',
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
                data: 'title',
                name: 'title',
            },
            {
                data: 'image',
                name: 'image',
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
            },
        ],
        order: [
            [4, 'desc']
        ]
    });

</script>
@endpush
