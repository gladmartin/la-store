@extends('layouts.admin')

@section('title', 'Tambah Akun bank')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah akun bank</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('setting.bank.store') }}" method="post" enctype="multipart/form-data">
                @csrf
               
                <input type="hidden" name="type" value="{{ request()->type }}">
                <div class="row">
                    <div class="form-group col-3">
                        <label for="bank">Bank</label>
                        <input id="meta[bank]" type="text" class="form-control @error('meta[bank]') is-invalid @enderror" name="meta[bank]" placeholder="Ketikkan nama bank nya" value="{{ old('meta.bank') }}" required>
                        @error('meta[bank]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                   
                  
                    <div class="form-group col-4">
                        <label for="konten">No rekening</label>
                        <input id="meta[no_rek]" type="text" class="form-control @error('meta[no_rek]') is-invalid @enderror" name="meta[no_rek]" placeholder="Ketikkan nama no. reknya" value="{{ old('meta.no_rek') }}" required>
                        @error('meta[no_rek]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-5">
                        <label for="konten">Atas nama</label>
                        <input id="meta[atas_nama]" type="text" class="form-control @error('meta[atas_nama]') is-invalid @enderror" name="meta[atas_nama]" placeholder="Ketikkan nama no. reknya" value="{{ old('meta.atas_nama') }}" required>
                        @error('meta[atas_nama]')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-7">
                        <label for="thumbnail">Logo bank</label>
                        <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}">
                        @error('thumbnail')
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