@extends('layouts.admin')

@section('title', 'Edit produk')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
            {{-- <button class="btn btn-dark btn-sm" type="button" data-toggle="modal" data-target="#modalScrape">Scrape produk</button> --}}
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-12">
                        <label for="produk">Produk</label>
                        <input id="produk" type="text" class="form-control form-control-lg @error('produk') is-invalid @enderror" name="produk" placeholder="Ketikkan nama produknya" value="{{ old('produk', $product->title) }}" required>
                        @error('produk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="harga">Harga dasar</label>
                        <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga', $product->harga) }}" required>
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="stok">Stok</label>
                        <input id="stok" min="1" type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $product->stok) }}" required>
                        @error('stok')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="berat">Berat produk (gram)</label>
                        <input id="berat" type="number" class="form-control @error('berat') is-invalid @enderror" name="berat" value="{{ old('berat', $product->berat) }}" required>
                        @error('berat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="kondisi">Kondisi produk</label>
                        <select id="kondisi" type="number" class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" required>
                            <option {{ old('kondisi', $product->kondisi) == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option {{ old('kondisi', $product->kondisi) == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        @error('kondisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-5">
                        <label for="thumbnail">Thumbnail produk</label>
                        <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}">
                        @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <small>Biarkan kosong jika tidak ingin thumbnail lama</small>
                    </div>
                    <div class="form-group col-lg-4 d-none">
                        <label for="galeri">Galeri produk</label>
                        <input id="galeri" type="file" class="form-control @error('galeri') is-invalid @enderror" name="galeri" value="{{ old('galeri') }}" multiple>
                        <small class="text-info">Anda bisa memilih lebih dari 1 gambar</small>
                        @error('galeri')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" type="number" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori') }}" required>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ old('kategori', $product->category_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                        </select>
                        @error('kategori')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="deskripsi">Deskripsi produk</label>
                        <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Deksiprsi lengkap dari produk ini" required rows="10">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

               <div class="row">
                <div class="col-12 form-group">
                    <label for="varian">Varian produk</label>
                    <div class="list-varian">
                        @foreach ($product->variants as $item)

                        <div class="row row-vairan-first">
                            <div class="form-group col-lg-3">
                            <input type="text" name="varian[{{ $loop->iteration }}][key]" value="{{ $item->key }}" placeholder="Nama varian" class="form-control">
                            </div>
                            <div class="form-group col-lg-3">
                                <input type="text" name="varian[{{ $loop->iteration }}][value]" value="{{ $item->value }}" placeholder="Value varian" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-4 d-none">
                                <input type="number" name="varian[{{ $loop->iteration }}][stok]" placeholder="Stok" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-8 d-none">
                                <input type="number" name="varian[{{ $loop->iteration }}][harga_tambahan]" placeholder="Harga tambahan" class="form-control">
                                <small class="text-info">Biarkan kosong jika harganya sama</small>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                    <a href="" class="badge badge-dark tambah-varian">Tambah varian</a>
                </div>
               </div>
               <hr>
                <button class="btn btn-primary shadow-sm btn-sm" type="submit">Proses Edit</button>

            </form>
        </div>
    </div>

    @endsection

@push('js')

<script>

    $('.tambah-varian').on('click', function(e) {
        e.preventDefault();
        tambahRowFormVarian();
    });

    function tambahRowFormVarian() {
        let varianFirst = $('.row-vairan-first:first').html()
        let countVarian = $('.list-varian .row').length;
        console.log(countVarian);
        varianFirst = varianFirst.replaceAll('varian[0]', `varian[${countVarian}]`)
        let listVarian = $('.list-varian');
        listVarian.append(`<div class='row'>${varianFirst}</div>`);
    }
</script>
  
@endpush