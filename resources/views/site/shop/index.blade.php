@extends('layouts.app')

@section('title', 'Belanja sekarang')

@push('meta')
<meta property="og:image" content="{{ asset('storage/' .$webOption->get('logo')) }}" />
<meta property="og:title" content="Belanja sekarang" />
<meta property="og:description" content="{{ $webOption->get('site_description') }}" />
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
                        <select name="category" id="kategori" class="form-control">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ request()->category == $item->id ? 'selected' : '' }} >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="range-harga">Batasan harga</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="price_min" value="{{ request()->price_min }}" placeholder="Rp min" id="price_min">
                            <input type="number" class="form-control" name="price_max" value="{{ request()->price_max }}" placeholder="Rp max" id="price_min">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="urutkan">Urutkan harga</label>
                        <select name="price_order" id="urutkan" class="form-control">
                            <option {{ request()->price_order == 'low_first' ? 'selected' : '' }} value="low_first">Harga rendah ke tinggi</option>
                            <option {{ request()->price_order == 'high_first' ? 'selected' : '' }} value="high_first">Harga tinggi ke rendah</option>
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
                <div class="row">
                    @each('components.card-item-product', $products, 'item', 'components.card-product-empty')
                </div>
                <div class="row justify-content-center">
                    {{ $products->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
