@extends('layouts.app')

@section('title', 'Belanja sekarang')

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
</div>
@endsection

@push('js')
@endpush
