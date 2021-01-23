@extends('layouts.admin')

@section('title', 'Daftar orderan masuk')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail order</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Invoice <span
                class="badge badge-danger">{{ $order->invoice }}</span></h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td>No invoice</td>
                <td>{{ $order->invoice }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $order->nama }}</td>
            </tr>
            <tr>
                <td>No Wa</td>
                <td>{{ $order->no_wa }}</td>
            </tr>
            <tr>
                <td>Tanggal order</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            <tr>
                <td>Produk yang dibeli</td>
                <td>
                    {{ $order->product->title ?? 'PRODUK TELAH DIHAPUS' }}
                    <div>
                        Kuantitas : <b>{{ $order->kuantitas }}</b>
                    </div>
                    <div>
                        Varian : <b>{{ $order->varian }}</b>
                    </div>
                    <div>
                        Total bayar : <b>{{ rupiah($order->delivery->ongkos_kirim + $order->bayar) }}</b>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Alamat pengataran</td>
                <td>{{ $order->alamat }}</td>
            </tr>
        </table>
    <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm shadow-sm">Kembali</a>
    </div>
</div>

@endsection

@push('js')
@endpush
