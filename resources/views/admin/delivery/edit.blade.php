@extends('layouts.admin')

@section('title', 'Edit pengantaran')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit pengantaran</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Invoice <span
                class="badge badge-danger">{{ $delivery->order->invoice }}</span></h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="row">
            <div class="col-lg-5">
                <b>Info pengantaran</b>
                <form action="{{ route('delivery.update', $delivery->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="resi">No resi</label>
                        <input name="resi" class="form-control" type="text" value="{{ old('resi', $delivery->no_resi) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary shadow btn-sm">Update</button>
                </form>
            </div>
            <div class="col-lg-7">
                <b>Detail pengantaran</b>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <td>Keterangan</td>
                                <td>Tanggal</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        @foreach ($deliveryDetail as $item)
                        <tbody>
                            <tr>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                <a class="btn btn-danger btn-sm shadow btn-delete" href="{{ route('delivery.delete.detail', $item->id) }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            <form action="{{ route('delivery.store.detail', $delivery->id) }}" method="post" class="bg-primary rounded p-2 mt-5">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" required name="keterangan" placeholder="Keterangan pengiriman">
                    </div>
                    <button class="btn btn-primary btn-block">Tambah detail pengantaran</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
@endpush
