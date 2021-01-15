@extends('layouts.app')

@section('title', 'Lacak pesanan')

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                Lacak pesanan
            </li>
        </ul>
    </nav>

    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Lacak pesanan</b>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="lastore-alert lastore-alert-primary mt-4 shadow-sm">
                            <div class="title">Info</div>
                            <div class="rows">
                                <div class="body col-8s">
                                    Untuk melakukan Lacak pesanan, silahkan masukkan no invoice kamu. perlu diketahui kami juga mengirim realtime pengiriman melalui no WhatsApp kamu
                                </div>
                            </div>
                            <div class="icon">
                                <img src="{{ asset('/svg/undraw_package_arrived_63rf.svg') }}" alt="Konfirmasi bayar" width="100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                       
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input required type="text" class="form-control" name="nama"
                                            placeholder="Ketikkan nomor invoice"
                                            aria-label="Ketikkan nomor invoice" aria-describedby="nama" id="nama">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('js')

@endpush
