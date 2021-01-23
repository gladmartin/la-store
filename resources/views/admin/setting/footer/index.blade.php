@extends('layouts.admin')

@section('title', 'Pengaturan web')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan web</h1>
</div>
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Widget footer</h6>
        <a href="{{ route('post.create', ['type=widget_footer']) }}" class="btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah footer</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-server-side">
                <thead>
                    <tr>
                        <th>Judul</th>
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
        ajax: '{{ route("dt.footer") }}',
        columns: [
            {
                data: 'title',
                name: 'title',
            },
            {
                data: 'aksi',
                name: 'aksi',
            },
        ]
    });

</script>
@endpush
