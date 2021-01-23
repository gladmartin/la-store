@extends('layouts.app')

@section('title', $webOption->get('site_description'))

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->get('logo') ) }}" />
<meta property="og:title" content="{{ $webOption->get('site_description') }} | {{ $webOption->get('site_title') }}" />
<meta property="og:description" content="{{ $webOption->get('site_description') }}" />
@endpush()

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-12">
            <div class="shadow-sm bg-white p-4 rounded">
                <h4>Ini bagian future product</h4>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Kategori</b>
                <hr>
                <div class="d-flex">
                    @foreach ($categories as $item)
                    <a href="{{ route('category.single', [$item->slug, $item->id]) }}">
                        <div class="mr-2 text-center">
                            <div class="category__box bg-dangers">
                                <img src="{{ $item->icon }}" alt="{{ $item->name }}">
                            </div>
                            <small class="category__text text-center">
                                {{ $item->name }}
                            </small>
                        </div>
                    </a>
                @endforeach
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Produk terlaris</b>
                <hr>
                <div class="row">
                    @each('components.card-item-product', $produkTerlaris, 'item')
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Produk terbaru</b>
                <hr>
                <div class="row">
                    @each('components.card-item-product', $produkTerbaru, 'item')
                </div>
                <div class="text-center">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">Lihat produk lainnya</a>
                </div>
            </div>
            
        </div>
       
    </div>
</div>
@endsection
