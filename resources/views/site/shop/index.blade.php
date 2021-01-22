@extends('layouts.app')

@section('title', 'Belanja sekarang')

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->logo) }}" />
<meta property="og:title" content="Belanja sekarang" />
<meta property="og:description" content="{{ $webOption->site_description }}" />
@endpush()

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                Belanja
            </li>
        </ul>
    </nav>
    <div class="row">
        <div class="col-lg-3 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <h5>Telusuri</h5>
                <hr>
                <form action="" method="get">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option>Semua kategori</option>
                            @foreach ($categories as $item)
                                <option {{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="range-harga">Batasan harga</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" placeholder="Rp Min" name="harga[minimal]" class="form-control">
                            </div>
                            <div class="col">
                                <input type="text" placeholder="Rp Maks" name="harga[maksimal]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="urutkan">Urutkan harga</label>
                        <select name="urutkan" id="urutkan" class="form-control">
                            <option value="1">Harga rendah ke tinggi</option>
                            <option value="2">Harga tinggi ke rendah</option>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block">Terapkan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-9 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <h5>Daftar produk</h5>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
