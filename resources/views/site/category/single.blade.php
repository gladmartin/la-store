@extends('layouts.app')

@section('title', 'Menampilkan hasil produk dengan kategori ' . $category->name)

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->get('logo')) }}" />
<meta property="og:title" content="Menampilkan hasil produk dengan kategori" />
<meta property="og:description" content="{{ $webOption->get('site_description') }}" />
@endpush()

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline center-mobiles">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            @foreach ($category->listParentAttribute() as $item)
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                <a href="{{ route('category.single', [$item->slug, $item->id]) }}">{{ $item->name }}</a>
            </li>
            @endforeach
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                List
            </li>
        </ul>
    </nav>
    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Menampilkan {{ $category->name }}</b>
                <hr>
                <div class="row">
                    @each('components.card-item-product', $category->products()->get(), 'item', 'components.card-product-empty')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
