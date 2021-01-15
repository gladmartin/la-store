@extends('layouts.app')

@section('title', 'Konfirmasi pembayaran')

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                Konfirmasi pembayaran
            </li>
        </ul>
    </nav>

    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Konfirmasi pembayaran</b>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="lastore-alert lastore-alert-primary mt-4 shadow-sm">
                            <div class="title">Info</div>
                                <div class="body">Untuk melakukan konfirmasi pembayaran, silahkan masukkan semua data pada form berikut ini. Kami akan segera memproses orderan Anda, setelah Anda melakukan konfirmasi pembayaran.</div>
                            <div class="icon">
                                <img src="{{ asset('/svg/undraw_transfer_money_rywa.svg') }}" alt="Konfirmasi bayar" width="100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input required type="text" class="form-control" name="invoice"
                                            placeholder="Ketikkan nomor invoice"
                                            aria-label="Ketikkan nomor invoice" aria-describedby="invoice" id="invoice">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input required type="text" class="form-control" name="nominal"
                                            placeholder="Nominal transfer"
                                            aria-label="Nominal transfer" aria-describedby="nominal" id="nominal">
                                            
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pengirim</span>
                                        </div>
                                        <input required type="text" class="form-control" name="nama_pengirim"
                                            placeholder="Nama rek. pengirim"
                                            aria-label="Nama rek. pengirim" aria-describedby="nama_pengirim" id="nama_pengirim">
                                            <select required name="bank_pengirim" id="bank_pengirim" class="form-control">
                                                <option disabled selected>Bank pengirim</option>
                                                <option>BRI</option>
                                                <option>BCA</option>
                                                <option>CIMB Niaga</option>
                                                <option>BTPN</option>
                                                <option>BNI</option>
                                                <option>Bank Daerah</option>
                                                <option>Lainnya</option>
                                            </select>
                                            
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Pilih Bank tujuan</span>
                                        </div>
                                       
                                            <select required name="bank_tujuan" id="bank_tujuan" class="form-control">
                                                <option disabled selected>Bank tujuan</option>
                                                <option>BRI</option>
                                                <option>BCA</option>
                                            </select>
                                            
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Konfirmasi pembayaran</button>
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
