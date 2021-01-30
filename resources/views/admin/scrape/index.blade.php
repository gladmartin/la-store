@extends('layouts.admin')

@section('title', 'Module scrape produk')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Scrape Produk</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Generate produk anda</h6>
        <div class="dropdown no-arrow d-none">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Dropdown Header:</div>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="alert alert-info">
            Marketplace yang di support: <b>Shopee dan TokoPedia</b>
        </div>
        <form action="" method="post" class="form-scrape">
            @csrf
            <div class="form-group">
                <input name="url_mp" type="url" id="url" placeholder="Masukkan url produk atau toko"
                    class="form-control">
            </div>
            {{-- <div class="form-group"> --}}
                <input type="checkbox" name="is_toko" id="is-toko"> 
                <label for="is-toko" class="mr-5">Url toko?</label>
                {{-- <div class="my-5"></div> --}}
                <input type="checkbox" name="run_background" id="run_background"> 
                <label for="run_background">Jalankan di background?</label>
            {{-- </div> --}}
            
           <div class="row">
            <div class="form-group col-lg-6">
                <label for="is-toko">Kali berapa persen</label>
                <input type="range" class="d-block col-12 col-lg-6" name="persen" id="persen" value="0" min="0" max="100" oninput="this.nextElementSibling.value = this.value">
                <output>0</output>%
            </div>
            <div class="form-group col-lg-6">
                <label for="is-toko">Tambah berapa rupiah</label>
                <input type="number" class="d-block col-12 col-lg-6 form-control" name="tambah" id="tambah" value="0" min="0">
            </div>
           </div>
            <button type="submit" class="btn btn-primary btn-sm shadow btn-mulai">
                <span class="icon-btn">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="txt">Mulai</span>
            </button>
        </form>


        <form action="{{ route('product.store') }}" method="post" class="form-product d-none" enctype="multipart/form-data">
            @csrf
           <input type="hidden" name="url_sumber" id="url-sumber">
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
                    <label for="persen">Persen harga</label>
                    <input id="persen" type="number" class="form-control @error('persen') is-invalid @enderror" name="persen" value="{{ old('persen') }}" required>
                    @error('persen')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-lg-6">
                    <label for="tambah">Tambah harga</label>
                    <input id="tambah" type="number" class="form-control @error('tambah') is-invalid @enderror" name="tambah" value="{{ old('tambah') }}" required>
                    @error('tambah')
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
                </div>
                <div class="form-group col-lg-4">
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
                    <input id="kategori" type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori') }}" required />
                    @error('kategori')
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

@endsection

@push('js')
<script>
    const supportMp = ['shopee.co.id', 'www.tokopedia.com', 'tokopedia.com'];
    let parseUrl;
    let isMuliptleProduct;
    $('.form-scrape').on('submit', async function (e) {
        e.preventDefault();
        let url = $('#url').val();
        if (!url) return;
        parseUrl = new URL(url);
        if (!supportMp.includes(parseUrl.host)) return alert('Marketplace tidak di support');
        $('.btn-mulai').attr('disabled', 'disabled');
        $('.btn-mulai .icon-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
        $('.btn-mulai .txt').html('Sedang memproses..');
        isMuliptleProduct = checkIsMultipleProduct();
        if (isRunInBackground()) {
            await fetchBackground();
            $('.form-scrape')[0].reset()
            $('.btn-mulai').removeAttr('disabled');
            $('.btn-mulai .icon-btn').html('<i class="fas fa-circle-notch fa-plus"></i>');
            $('.btn-mulai .txt').html('Mulai');
            alert('Scrape sedang berjalan dibackground server');
            return;
        }

        try {
            if (!isMuliptleProduct) {
                await fetchSingleProduct();
                await postProduct();
            } else {
                await handleMultipleProduct();
            }
        } catch (error) {
            
        }
        $('.form-scrape')[0].reset()
        $('.btn-mulai').removeAttr('disabled');
        $('.btn-mulai .icon-btn').html('<i class="fas fa-circle-notch fa-plus"></i>');
        $('.btn-mulai .txt').html('Mulai');
        alert('Selesai');
    });

    async function handleMultipleProduct() {
        let products = await fetchMultipleProduct();
        if (!products) return alert('Gagal mengambil list produk');
        i = 1;
        for (const product of products) {
            $('.btn-mulai .txt').html(`Sedang memproses.. ${i} dari ${products.length} item`);
            parseUrl = new URL(product.api_url);
            await fetchSingleProduct();
            await postProduct();
            i++;
        }
    }

    function checkIsMultipleProduct() {
        if (!parseUrl) return;
        let isUrlToko = $('#is-toko').is(":checked");
        return isUrlToko;
        if (parseUrl.host == 'shopee.co.id') {
            return parseUrl.href.includes('https://shopee.co.id/shop') ? true : false;
        }
    }

    function isRunInBackground() {
        return $('#run_background').is(":checked");
    }

    async function fetchBackground() {
        const raw = await fetch(`${BASE_URL_ADMIN}/scrape-mp/background`, {
            method: 'post',
            headers : {
                'accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: $('.form-scrape').serialize(),
        });

        console.log(raw);
    }

    async function fetchMultipleProduct() {

        const raw = await fetch(`${BASE_URL_ADMIN}/scrape-mp/multiple?url=${encodeURIComponent(parseUrl.href)}`, {
            headers: {
                'accept': 'application/json',
            }
        });
        const response = await raw.json();
        if (!response.success) return false;
        return response.data;
        
    }

    async function fetchSingleProduct() {
        let persen = $('#persen').val();
        let tambah = $('#tambah').val();
        $('input[name="persen"]').val(persen);
        $('input[name="tambah"]').val(tambah);
        const raw = await fetch(`${BASE_URL_ADMIN}/scrape-mp/single?url=${encodeURIComponent(parseUrl.href)}&persen=${persen}&tambah=${tambah}`, {
            headers: {
                'accept': 'application/json',
            }
        });
       
        const response = await raw.json();
        if (!response.success) {
            // return alert('gagal');
            return;
        }
        const data = response.data;
        $('#modalScrape').modal('hide');
        $('#produk').val(data.name);
        $('#url-sumber').val(parseUrl.href);
        $('#kategori').val(data.categories[data.categories.length - 1]);
        $('#deskripsi').val(data.description);
        $('#stok').val(data.stock);
        $('#berat').val(data.weight);
        $('#harga').val(data.price);
        $('#thumbnail').attr('type', 'text');
        $('#thumbnail').val(data.thumbnail);
        $('#galeri').attr('type', 'text');
        $('#galeri').val(data.images.join('|'));
        let i = 0;
        for (const variant of data.variants) {
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

    async function postProduct() {
        let body = $('.form-product').serialize();
        await $.ajax({
            method: 'post',
            url: `${BASE_URL_ADMIN}/product`,
            data: body,
            success: function(data) {
                console.log(data);
            },
            error: function(e) {
                console.log(e);
            }
        });

    }

    function tambahRowFormVarian() {
        let varianFirst = $('.row-vairan-first:first').html()
        let countVarian = $('.list-varian .row').length;
        varianFirst = varianFirst.replaceAll('varian[0]', `varian[${countVarian}]`)
        let listVarian = $('.list-varian');
        listVarian.append(`<div class='row'>${varianFirst}</div>`);
    }

</script>
@endpush
