@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline center-mobile">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            @foreach ($product->category()->first()->listParentAttribute() as $item)
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                <a href="{{ route('category.single', [$item->slug, $item->id]) }}">{{ $item->name }}</a>
            </li>
            @endforeach
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                {{ $product->title }}
            </li>
        </ul>
    </nav>
    <form action="/put-order" method="post">
        @csrf

        <div class="row">
            <div class="col-12 px-xs-0">
                <div class="shadow-sm bg-white p-4 rounded">
                    <div class="row">
                        <div class="col-lg-5 mb-4">
                            <div id="carouselProductImageControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ $product->image }}" class="d-block w-100" alt="{{ $product->title }}">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselProductImageControls" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselProductImageControls" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <h2>{{ $product->title }}</h2>
                            <small class="text-gray">{{ $product->terjual }} Terjual</small>
                            <div class="mt-4">
                                @if ($product->diskon > 0)
                                <div class="diskon">
                                    <span class="badge badge-danger">{{ $product->diskon }}%</span>
                                    <span class="harga-dasar">{{ $product->hargaRupiah($product->harga) }}</span>
                                </div>
                                @endif
                                <div class="harga-akhir mt-2">{{ $product->hargaRupiah($product->harga_akhir) }}</div>
                                <hr>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <th width="90px">Berat</th>
                                        <td>{{ $product->berat }} gr</td>
                                    </tr>
                                    <tr>
                                        <th width="90px">Jumlah</th>
                                        <td>
                                            <input value="1" type="number" min="1" max="{{ $product->stok }}" class="form-control col-2 mb-2" id="qty">
                                        </td>
                                    </tr>
                                    @foreach ($product->variasi as $item)
                                    <tr>
                                        <th width="90px">{{ $item['name'] }}</th>
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($item['items'] as $varian)
                                                <div class="mb-3">
                                                    <a class="px-4 mr-2 btn-variasi {{ $item['name'] }} {{ $loop->iteration == 1 ? 'terpilih' : '' }}" data-variasi="{{ $item['name'] }}" data-id="{{ $varian['id'] }}" href="/#">{{ $varian['name'] }}</a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <h5>Deskripsi</h5>
                            <hr>
                            <div class="deskripsi">
                                {!! $product->deskripsi !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-7 px-xs-0">
                <div class="shadow-sm bg-white p-4 rounded">
                    <h5>Lengkapi data pengiriman</h5>
                    <hr>
                    <div class="alert alert-primary">
                        <b>PENTING!</b> Mohon mengisi informasi Anda di bawah ini dengan teliti dan lengkap agar produk yang
                        Anda beli dapat dikirimkan ke rumah Anda tanpa terkendala.
                    </div>
                    {{-- <form action="" method="post"> --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input required type="text" class="form-control" name="nama"
                                        placeholder="Ketikkan nama lengkap penerima"
                                        aria-label="Ketikkan nama lengkap penerima" aria-describedby="nama" id="nama">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >@</span>
                                    </div>
                                    <input required type="email" id="email" class="form-control" name="email"
                                        placeholder="Masukkan email yang aktif" aria-label="Masukkan email yang aktif"
                                        aria-describedby="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" ><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input required type="text" id="wa" class="form-control" name="wa"
                                        placeholder="Masukkan WhatsApp yang aktif" aria-label="Masukkan WhatsApp yang aktif"
                                        aria-describedby="wa">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <div class="icon-provinsi">
                                                <i class="fas fa-circle-notch fa-spin"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <select required class="custom-select" id="provinsi" class="provinsi" disabled>
                                        <option selected disabled>Pilih provinsi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text icon-kota"><i class="fa fa-map-marked-alt"></i></span>
                                    </div>
                                    <select required class="custom-select" id="city" class="kota" disabled>
                                        <option selected disabled>Pilih kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text icon-kecamatan"><i class="fa fa-map-marked-alt"></i></span>
                                    </div>
                                    <select required class="custom-select" id="subdistrict" class="kecamatan" disabled>
                                        <option selected disabled>Pilih kecamatan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 label-layanan" style="display: none">
                                        <b>Pilih layanan ekspedisi</b>
                                    </div>
                                </div>
                                <div class="row ongkir-list">
                                    {{-- <div class="col-4">
                                        <div class="bg-white ongkir-card shadow-md py-1 px-2 text-center rounded border">
                                            <b class="expedisi">JNE</b>
                                            <span class="service">OKE</span>
                                            <div class="d-flex justify-content-center" style="font-size: 10px">
                                                <div class="etd text-small">8-9 Hari</div>
                                                <div class="mx-2"></div>
                                                <div class="ongkir-cost"><b>Rp 80.000</b></div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row ongkir-list-loading" style="display: none">
                                    <div class="col-4">
                                        <div disabled class="shine ongkir-card shadow-md py-1 px-2 text-center rounded " style="width:100%"></div>
                                    </div>
                                    <div class="col-4">
                                        <div disabled class="shine ongkir-card shadow-md py-1 px-2 text-center rounded " style="width:100%"></div>
                                    </div>
                                    <div class="col-4">
                                        <div disabled class="shine ongkir-card shadow-md py-1 px-2 text-center rounded " style="width:100%"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="wa"><i class="fa fa-map-marker"></i></span>
                                    </div>
                                    <textarea required type="text" id="alamat" class="form-control" name="alamat"
                                        placeholder="Alamat lengkap, contoh Jl. bunga nomor 11"
                                        aria-label="Alamat lengkap, contoh Jl. bunga nomor 11"></textarea>
                                </div>
                            </div>

                        </div>
                    {{-- </form> --}}
                </div>
            </div>
            <div class="col-lg-5 px-xs-0">
                <div class="shadow-sm bg-white p-4 rounded">
                    <h5>Detail pesanan</h5>
                    <hr>
                    <table class="table table-sm table-borderless table-detail-pesanan">
                        <tr>
                            <td>Harga</td>
                            <td class="text-right">
                                {{-- @if ($product->diskon > 0)
                                <span class="harga-dasar">{{ $product->hargaRupiah($product->harga) }}</span>
                                @endif --}}
                                <span class="harga-final">{{ $product->hargaRupiah($product->harga_akhir) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Ongkir</td>
                            <td class="text-right"><span class="biaya-ongkir">Rp 0</span></td>
                        </tr>
                        <tr>
                            <th><b>TOTAL</b></th>
                            <th class="text-right">
                                <span class="biaya-total">{{ $product->hargaRupiah($product->harga_akhir) }}</span>
                            </th>
                        </tr>

                    </table>
                    <button type="submit" class="btn btn-primary btn-lg btn-block btn-submit">
                        <span class="icon-btn">
                            <i class="fa fa-shopping-cart"></i> 
                        </span>
                        Proses pesanan
                    </button>
                    <div class="message-order mt-4">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>

// window.onerror = function (message, url, lineNo){
//     alert('Error: ' + message + '\n' + 'Line Number: ' + lineNo);
//     return true;
// }
    //declare global variable --i know this is a dirty js code :D
    var beratProduk = {{ $product->berat }};
    var kuantitas = 1;
    var costOngkir = null;
    var hargaDasar = {{ $product->harga }}
    var hargaFinal = {{ $product->harga_akhir }}
    var subTotal = {{ $product->harga_akhir }};
    var totalBiaya = 0;
    var kecamatan = null;
    var productId = {{ $product->id }}
    var selectedEkspedisi;

    async function loadAllProvince() {
        const raw = await fetch(`${BASE_URL_API}/province`, {
            headers: {
                'accept': 'application/json',
            }
        });
        const response = await raw.json();

        if (!response.success) {
            alert('Failed load province data');
            return;
        }
        let provinceSelect = $('#provinsi');
        for (const province of response.results) {
            provinceSelect.append(new Option(province.title, province.province_id));
        }
        $('.icon-provinsi').html('<i class="fa fa-map-marked-alt"></i>');
        $('#provinsi').removeAttr('disabled');
    }

    function autoCompleteInput() {
        let data = localStorage.getItem('lastTransaksi');
        try {
            data = JSON.parse(data);
        } catch (error) {
            return;
        }
        if (!data) return;
        setInput('#nama', data.nama);
        setInput('#email', data.email);
        setInput('#wa', data.no_wa);
        setInput('#provinsi', data.provinsi);
        setInput('#alamat', data.alamat);
        if (data.provinsiHtml) {
            $('#provinsi').html(data.provinsiHtml);
            $('#provinsi').val(data.provinsi);
            $('#provinsi').removeAttr('disabled');
        }
        if (data.kotaHtml) {
            $('#city').html(data.kotaHtml);
            $('#city').val(data.kota);
            $('#city').removeAttr('disabled');
        }
        if (data.kecamatanHtml) {
            $('#subdistrict').html(data.kecamatanHtml);
            $('#subdistrict').val(data.kecamatan);
            $('#subdistrict').removeAttr('disabled');

            hitungOngkir();
        }
    }
    
    loadAllProvince();
    
    autoCompleteInput();


    function setInput(id, value) {
        $(`${id}`).val(value);
    }
    
    async function loadCity() {
        let provinceId = $('#provinsi').val();
        if (!provinceId) {
            alert('Pilih provinsi dahulu');
            return;
        }
        $('.icon-kota').html('<i class="fa fa-circle-notch fa-spin"></i>');
        const raw = await fetch(`${BASE_URL_API}/city?province_id=${provinceId}`, {
            headers: {
                'accept': 'application/json',
            }
        });
        $('.icon-kota').html('<i class="fa fa-map-marked-alt"></i>');
        const response = await raw.json();

        if (!response.success) {
            alert('Failed load city data');
            return;
        }
        let citySelect = $('#city');
        for (const city of response.results) {
            citySelect.append(new Option(city.title, city.city_id));
        }
        $('#city').removeAttr('disabled');
        
    }

    async function loadSubdisctrict() {
        let city = $('#city').val();
        if (!city) {
            alert('Pilih kota dahulu');
            return;
        }
        
        $('.icon-kecamatan').html('<i class="fa fa-circle-notch fa-spin"></i>');
        const raw = await fetch(`${BASE_URL_API}/subdistrict?city_id=${city}`, {
            headers: {
                'accept': 'application/json',
            }
        });
        
        $('.icon-kecamatan').html('<i class="fa fa-map-marked-alt"></i>');
        const response = await raw.json();

        if (!response.success) {
            alert('Failed load subdistrict data');
            return;
        }
        let subdistrictSelect = $('#subdistrict');
        for (const subdistrict of response.results) {
            subdistrictSelect.append(new Option(subdistrict.subdistrict_name, subdistrict.subdistrict_id));
        }
        $('#subdistrict').removeAttr('disabled');
    }

    $('#provinsi').on('change', function (e) {
        resetCityList();
        resetSubdisctrictList();
        loadCity();
        resetEkspedisiList();
    });

    $('#city').on('change', function (e) {
        resetSubdisctrictList();
        loadSubdisctrict();
        resetEkspedisiList();
    });

    $('#subdistrict').on('change', function (e) {
        $('.label-layanan').show();
        hitungOngkir();
    });

    function resetEkspedisiList() {
        selectedEkspedisi = null;
        costOngkir = 0;
        $('.label-layanan').hide();
        $('.ongkir-list').html('');
        hitungTotalBiaya();
    }

    function resetCityList() {
        $('#city').attr('disabled', 'disabled');
        $('#city').empty();
        $('#city').append(new Option('Pilih kota'));
    }

    function resetSubdisctrictList() {
        $('#subdistrict').attr('disabled', 'disabled');
        $('#subdistrict').empty();
        $('#subdistrict').append(new Option('Pilih kecamatan'));
    }

    // btn variasi function
    $('.btn-variasi').on('click', function (e) {
        e.preventDefault();
        let variasi = $(this).data('variasi');
        $(`.btn-variasi.${variasi}`).removeClass('terpilih');
        $(this).toggleClass('terpilih');
    })

    $('body').on('click', '.ongkir-card', function (e) {
        e.preventDefault();
        $('.ongkir-card').removeClass('terpilih');
        $(this).toggleClass('terpilih');
        tambahBiayaOngkir();
    })

    // hitungOngkir();
    
    async function hitungOngkir() {
        kecamatan = $('#subdistrict').val();
        // kecamatan = 4045;
        if (!kecamatan) {
            alert('Pilih kecamatan dahulu');
            return;
        }

        // shimmer Ekspedisi
        $('.ongkir-list-loading').show();
        $('.ongkir-list').html('');
        $('.label-layanan').show();

        const raw = await fetch(`${BASE_URL_API}/ongkir?` + new URLSearchParams({
            ke: kecamatan,
            berat: beratProduk
        }), {
            headers: {
                'accept': 'application/json',
            },
        });
        $('.ongkir-list-loading').hide();
        const response = await raw.json();
        if (!response.success) {
            $('.ongkir-list').html('Failed load ongkir data');
            console.log(response);
            return;
        }
        let html = '';
        for (const item of response.results) {
            for (const layanan of item.costs) {
                let data = {
                    ekspedisi: item.code,
                    service: layanan.service,
                    etd: layanan.cost[0].etd ?? '',
                    harga: layanan.cost[0].value ?? '',
                }
                html += buildCardOngkir(data);
            }
        }
        $('.ongkir-list').html(html);

    }

    function buildCardOngkir(data) {
        let html = `<div class="col-6 col-lg-4">
                        <div class="bg-white ongkir-card shadow-md py-1 px-2 text-center rounded border mb-2" data-cost=${encodeURIComponent(JSON.stringify(data))}>
                            <b class="expedisi text-uppercase">${data.ekspedisi}</b>
                            <small class="service">${data.service}</small>
                            <div class="d-flex justify-content-center" style="font-size: 10px">
                                <div class="etd text-small">${data.etd} Hari</div>
                                <div class="mx-2"></div>
                            <div class="ongkir-cost"><b>Rp ${data.harga.toLocaleString()}</b></div>
                            </div>
                        </div>
                    </div>`;
        return html;
    }

    function tambahBiayaOngkir() {
        selectedEkspedisi = $('.ongkir-card.terpilih').data('cost');
        selectedEkspedisi = decodeURIComponent(selectedEkspedisi);
        if (!selectedEkspedisi) return;
        selectedEkspedisi = JSON.parse(selectedEkspedisi);
        if (!selectedEkspedisi.harga) return;
        costOngkir = selectedEkspedisi.harga;
        hitungTotalBiaya();
    }
    

    function rupiah(number) {
        return 'Rp ' + number.toLocaleString();
    }

    function hitungTotalBiaya() {
        subTotal = hargaFinal * kuantitas;
        totalBiaya = subTotal + costOngkir;
        $('.harga-final').html(rupiah(subTotal));
        $('.biaya-ongkir').html(rupiah(costOngkir));
        $('.biaya-total').html(rupiah(totalBiaya));
    }

    $('#qty').on('change', function() {
        let val = parseInt($(this).val());
        kuantitas = val;
        hitungTotalBiaya();
    })

    $('form').on('submit', async function(e) {
        e.preventDefault();
        await submitOrder();
        
    });

    async function submitOrder() {
        $('.message-order').html('');
        if (!kecamatan) {
            return putMessageOrder('Pilih kecamatan anda dahulu.', 'error');
        }
        if (!costOngkir) {
            return putMessageOrder('Pilih layanan ekspedisi dahulu.', 'error');
        }
        $('.btn-submit').attr('disabled', 'disabled');
        $('.icon-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');

        let noWa = $('#wa').val();
        let nama = $('#nama').val();
        let email = $('#email').val();
        let alamat = $('#alamat').val();
        let kota = $('#city').val();
        let kotaHtml = $('#city').html();
        let provinsi = $('#provinsi').val();
        let provinsiHtml = $('#provinsi').html();
        let kecamatanHtml = $('#subdistrict').html();
        let variants = [];
        $('.btn-variasi.terpilih').each(function() {
            let variantId = $(this).data('id');
            if (!variantId) return;
            variants.push(variantId);
        });


        let body = {
            kuantitas,
            product_id: productId,
            kecamatan,
            no_wa: noWa,
            nama,
            email,
            alamat,
            provinsi,
            kota,
            variants,
            ekspedisi: selectedEkspedisi.ekspedisi,
            ongkos_kirim: selectedEkspedisi.harga,
            service: selectedEkspedisi.service,
        }
        const raw = await fetch(BASE_URL + '/order', {
            method: 'post',
            headers : {
                'accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        })
        
        $('.btn-submit').removeAttr('disabled');
        $('.icon-btn').html('<i class="fa fa-shopping-cart"></i>');
        let response = await raw.json();

        if (!response.success) {
            let msg = response.message || 'Gagal membuat pesanan anda';
            putMessageOrder(msg, 'error');
            console.log(response);
            return;
        }

        localStorage.setItem('lastTransaksi', JSON.stringify({
            nama,
            kecamatan,
            kecamatanHtml,
            provinsi,
            provinsiHtml,
            kota,
            kotaHtml,
            no_wa: noWa,
            nama,
            email,
            alamat,
        }));

        location.href = response.__next;
        
    }

    function putMessageOrder(html, style = null) {
        if (style == 'error') {
            html = `<div class="alert alert-danger">${html}</div>`
        }
        $('.message-order').html(html);
    }


</script>
@endpush
