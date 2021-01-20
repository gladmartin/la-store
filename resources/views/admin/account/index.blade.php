@extends('layouts.admin')

@section('title', 'Your Account')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Akun</h1>
</div>
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('account.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                </div>
                <div class="form-group col-lg-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                </div>
                <div class="form-group col-lg-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" value="">
                    <small class="text-info">Biarkan kosong jika tidak ingin merubah password lama.</small>
                </div>
            </div>
            
            <button class="btn btn-primary btn-sm shadow-sm" type="submit">Simpan perubahan</button>
        </form>
    </div>
</div>

@endsection
