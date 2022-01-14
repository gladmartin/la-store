@extends('layouts.admin')

@section('title', 'Edit Post')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="type" value="{{ request()->type }}">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="judul">Judul</label>
                        <input id="judul" type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" name="judul" placeholder="Ketikkan nama judulnya" value="{{ old('judul', $post->title) }}" required>
                        @error('judul')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @if (!request()->type || request()->type == 'post')
                    <div class="form-group col-lg-12">
                        <label for="thumbnail">Thumbnail post</label>
                        <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}">
                        @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <small>Biarkan kosong, jika tidak ingin mengganti thumbnail lama</small>
                    </div>
                    @endif
                  
                    <div class="form-group col-12">
                        <label for="konten">Konten</label>
                        <textarea id="konten" class="form-control text-editor @error('konten') is-invalid @enderror" name="konten" value="{{ old('konten') }}" placeholder="Konten isikan disni" required rows="10">{{ old('konten', $post->content) }}</textarea>
                        @error('konten')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary shadow-sm btn-sm" type="submit">Proses ubah</button>

            </form>
        </div>
    </div>


@endsection

@push('js')

  
@endpush