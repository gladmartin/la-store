@extends('layouts.admin')

@section('title', 'Tambah Blacklist')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah blacklist</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('blacklist.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{ request()->type }}">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="blacklist">Teks yang dihapus</label>
                        <textarea id="blacklist" type="text" class="form-control form-control-lg @error('blacklist') is-invalid @enderror" name="blacklist" placeholder="Blacklist template.." required>{{ old('blacklist') }}</textarea>
                        @error('blacklist')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                 
                </div>

                <button class="btn btn-primary shadow-sm btn-sm" type="submit">Proses tambah</button>

            </form>
        </div>
    </div>


@endsection

@push('js')

  
@endpush