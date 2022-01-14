@extends('layouts.admin')

@section('title', 'Tambah Shortcode')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Shortcode</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('option.store') }}" method="post" >
                @csrf
                <input type="hidden" name="type" value="{{ request()->type }}">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="shortcode_judul">ShortCode Judul</label>
                        <textarea id="shortcode_judul" type="text" class="form-control form-control-lg @error('option.shortcode_judul') is-invalid @enderror" name="option[shortcode_judul]" placeholder="Masukkan shortcode judul" required>{{ old('option.shortcode_judul',$webOption->get('shortcode_judul')) }}</textarea>
                        <small>Variable: {%judul%} , {%harga%}</small>
                        @error('option.shortcode_judul')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                 
                </div>

                <button class="btn btn-primary shadow-sm btn-sm" type="submit">Simpan</button>

            </form>
        </div>
    </div>


@endsection
