@extends('layouts.app')

@section('title', $category->title)

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline center-mobile">
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
</div>
@endsection

@push('js')
@endpush
