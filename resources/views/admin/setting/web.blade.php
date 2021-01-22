@extends('layouts.admin')

@section('title', 'Pengaturan web')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan web</h1>
</div>
<div class="card shadow">
    <div class="card-body">
    <form action="{{ route('setting.web.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>Nama toko / nama web</label>
                    <input type="text" name="options[site_title]" class="form-control"
                        value="{{ $webOption->get('site_title') }}">
                </div>
                <div class="form-group col-lg-8">
                    <label>Deskripsi / tagline web</label>
                    <input type="text" name="options[site_description]" class="form-control"
                        value="{{ $webOption->get('site_description') }}">
                </div>
                <div class="form-group col-lg-4">
                    <label>Kontak WA / No hp</label>
                    <input type="text" name="options[phone]" class="form-control" value="{{ $webOption->get('phone') }}">
                </div>
                <div class="form-group col-lg-4">
                    <label>Logo toko</label>
                    <input type="file" name="logo" class="form-control" value="{{ $webOption->get('logo') }}">
                    <small>Biarkan kosong jika tidak ingin merubahnya.</small>
                </div>
                <div class="form-group col-lg-4">
                    <label>Kontak email</label>
                    <input type="text" name="options[email]" class="form-control" value="{{ $webOption->get('email') }}">
                </div>
               
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label>Alamat toko / Alamat pengantaran</label>
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
                    <select name="options[province]" required class="custom-select" id="provinsi" class="provinsi" disabled data-province="{{ $webOption->get('province') }}">
                            <option selected disabled>Pilih provinsi</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text icon-kota"><i class="fa fa-map-marked-alt"></i></span>
                        </div>
                        <select required class="custom-select" name="options[city]" id="city" class="kota" disabled data-city="{{ $webOption->get('city') }}">
                            <option selected disabled>Pilih kota</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text icon-kecamatan"><i class="fa fa-map-marked-alt"></i></span>
                        </div>
                        <select required class="custom-select" name="options[subdistrict]" id="subdistrict" class="kecamatan" disabled data-subdistrict="{{ $webOption->get('subdistrict') }}">
                            <option selected disabled>Pilih kecamatan</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="wa"><i class="fa fa-map-marker"></i></span>
                        </div>
                        <textarea required placeholder="Masukkan alamat lengkap atau nama jalan" type="text" id="alamat" class="form-control" name="options[address]">{{ $webOption->get('address')}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-2">
                    <label>Skin web</label>
                    <input type="color" name="options[site_default_color]" class="form-control" value="{{ $webOption->get('site_default_color')}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Link google font <a href="https://fonts.google.com/" target="blank">Cari disni</a></label>
                    <input required type="url" name="options[site_default_font_url]" class="form-control" value="{{ $webOption->get('site_default_font_url')}}">
                    <small>Masukkan link fontnya, contoh <b>https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap</b></small>
                </div>
                <div class="form-group col-lg-4">
                    <label>Font family</a></label>
                    <input required type="text" name="options[site_default_font_family]" class="form-control" value="{{ $webOption->get('site_default_font_family')}}">
                    <small>Contoh <b>Roboto</b>, samakan dengan url yg dimasukkan.</small>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary btn-sm shadow" type="submit">Perbarui</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('js')
<script>
        //declare global variable --i know this is a dirty js code :D
        var kecamatan = null;
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
    
        async function autoCompleteInput() {
            await loadAllProvince();
            let province = $('#provinsi').data('province');
            let city = $('#city').data('city');
            let subdistrict = $('#subdistrict').data('subdistrict');
            if (province) {
                $('#provinsi').val(province);
                await loadCity();
            }
            if (city) {
                $('#city').val(city);
                await loadSubdisctrict();
            }
            if (subdistrict) {
                $('#subdistrict').val(subdistrict);
            }
        }
        
        
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
        });
    
        $('#city').on('change', function (e) {
            resetSubdisctrictList();
            loadSubdisctrict();
        });
    
        $('#subdistrict').on('change', function (e) {
            $('.label-layanan').show();
        });
    
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
    
    </script>
@endpush