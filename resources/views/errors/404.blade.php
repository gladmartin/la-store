@extends('layouts.app')

@section('title', 'Produk atau halaman tidak ditemukan')

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->get('logo') ) }}" />
<meta property="og:title" content="Produk atau halaman tidak ditemukan" />
<meta property="og:description" content="Produk atau halaman tidak ditemukan" />
@endpush()

@section('content')
<div class="container mt-4">
   
    <div class="row justify-content-center mt-4">
        <div class="col-lg-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded text-center">
               <h3>Opps!!</h3>
            <img src="{{ asset('img/undraw_feeling_blue_4b7q.svg') }}" alt="" width="200" >
               <p>Produk atau halaman yang kamu cari tidak dapat kami temukan!</p>
                <a class="btn btn-primary" href="{{ route('shop.index') }}">Mari belanja yang lain.</a>
            </div>
        </div>
    </div>
</div>
@endsection


