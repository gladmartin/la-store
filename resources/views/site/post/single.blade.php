@extends('layouts.app')

@section('title', $post->title)

@push('meta')
<meta property="og:image" content="{{ $post->image }}" />
<meta property="og:title" content="{{ $post->title }}" />
<meta property="og:description" content="{{ substr($post->content, 0, 100) }}" />
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
                {{ $post->title }}
            </li>
        </ul>
    </nav>
    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <h3>{{ $post->title }}</h3>
                {{-- <small>Dipost {{ $post->created_at->diffForHumans() }}</small> --}}
                <hr>
                <img src="{{ $post->image }}" alt="Thumbnail" width="100%" class="rounded shadow">
                <div class="content mt-5">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
