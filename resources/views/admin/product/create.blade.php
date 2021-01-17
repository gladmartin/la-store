@extends('layouts.admin')

@section('title', 'Tambah produk')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Isikan form dibawah ini</h6>
            <button class="btn btn-dark btn-sm" type="button" data-toggle="modal" data-target="#modalScrape">Scrape produk</button>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
               
                <div class="row">
                    <div class="form-group col-12">
                        <label for="produk">Produk</label>
                        <input id="produk" type="text" class="form-control form-control-lg @error('produk') is-invalid @enderror" name="produk" placeholder="Ketikkan nama produknya" value="{{ old('produk') }}" required>
                        @error('produk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="harga">Harga dasar</label>
                        <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" required>
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="stok">Stok</label>
                        <input id="stok" min="1" type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok') }}" required>
                        @error('stok')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="berat">Berat produk</label>
                        <input id="berat" type="number" class="form-control @error('berat') is-invalid @enderror" name="berat" value="{{ old('berat') }}" required>
                        @error('berat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="kondisi">Kondisi produk</label>
                        <select id="kondisi" type="number" class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" value="{{ old('kondisi') }}" required>
                            <option {{ old('kondisi') }}>Baru</option>
                            <option {{ old('kondisi') }}>Bekas</option>
                        </select>
                        @error('kondisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="thumbnail">Thumbnail produk</label>
                        <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}">
                        @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="galeri">Galeri produk</label>
                        <input id="galeri" type="file" class="form-control @error('galeri') is-invalid @enderror" name="galeri" value="{{ old('galeri') }}" multiple>
                        <small class="text-info">Anda bisa memilih lebih dari 1 gambar</small>
                        @error('galeri')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="deskripsi">Deskripsi produk</label>
                        <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Deksiprsi lengkap dari produk ini" required rows="10"></textarea>
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
                        <div class="row row-vairan-first">
                            <div class="form-group col-lg-3">
                                <input type="text" name="varian[0][key]" placeholder="Nama varian" class="form-control">
                            </div>
                            <div class="form-group col-lg-3">
                                <input type="text" name="varian[0][value]" placeholder="Value varian" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-4">
                                <input type="number" name="varian[0][stok]" placeholder="Stok" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-8">
                                <input type="number" name="varian[0][harga_tambahan]" placeholder="Harga tambahan" class="form-control">
                                <small class="text-info">Biarkan kosong jika harganya sama</small>
                            </div>
                        </div>
                    </div>
                    <a href="" class="badge badge-dark tambah-varian">Tambah varian</a>
                </div>
               </div>
               <hr>
                <button class="btn btn-primary shadow-sm btn-sm" type="submit">Proses tambah</button>

            </form>
        </div>
    </div>


    <!-- Modal scrape -->
    <div class="modal" id="modalScrape" tabindex="-1" aria-labelledby="modalScrapeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalScrapeLabel">Scrape produk</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Marketplace yang di support: <b>Shopee, BukaLapak dan TokoPedia</b>
                </div>
                <form action="" method="post" class="form-scrape">
                    @csrf
                    <div class="form-group">
                        <input name="url_mp" type="url" id="url" placeholder="Masukkan url produk" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm shadow btn-mulai">
                        <span class="icon-btn">
                            <i class="fa fa-plus"></i>
                        </span>
                         Mulai
                    </button>
                </form>
            </div>
           
          </div>
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

    $('.form-scrape').on('submit', function(e) {
        e.preventDefault();
        let url = $('#url').val();
        if (!url) return;
        fetchSingleProduct(url);
    });

    async function fetchSingleProduct(url) {
        $('.btn-mulai').attr('disabled', 'disabled');
        $('.btn-mulai .icon-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
        const raw = await fetch(`${BASE_URL_ADMIN}/scrape-mp/single?url=${url}`, {
            headers: {
                'accept': 'application/json',
            }
        });
        $('.btn-mulai').removeAttr('disabled');
        $('.btn-mulai .icon-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
        $('.icon-kota').html('<i class="fa fa-map-marked-alt"></i>');
        const response = await raw.json();
        if (!response.success) {
            return alert('gagal');
        }
        const data = response.data;
        $('#modalScrape').modal('hide');
        $('#produk').val(data.name);
        $('#deskripsi').val(data.description);
        $('#stok').val(data.stock);
        $('#berat').val(data.weight);
        $('#harga').val(data.price);
        $('#thumbnail').attr('type', 'text');
        $('#thumbnail').val(data.thumbnail);
        $('#galeri').attr('type', 'text');
        $('#galeri').val(data.images.join(','));
        let i = 0;
        for (const variant of data.variants) {
            console.log(variant);
            if (i !== 0) {
                tambahRowFormVarian();
            } 
            $(`[name="varian[${i}][key]"]`).val(variant.name);
            $(`[name="varian[${i}][value]"]`).val(variant.value);
            $(`[name="varian[${i}][stok]"]`).val(variant.stock ?? data.stock);
            $(`[name="varian[${i}][harga_tambahan]"]`).val(variant.price_add);
            i++;
        }
    }
</script>
  
@endpush