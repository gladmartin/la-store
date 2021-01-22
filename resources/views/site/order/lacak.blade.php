@extends('layouts.app')

@section('title', 'Lacak pesanan')

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->logo) }}" />
<meta property="og:title" content="Lacak pesanan" />
<meta property="og:description" content="{{ $webOption->site_description }}" />
@endpush()

@section('content')
<div class="container mt-4">
    <nav class="la-breadcrumb" aria-label="breadcrumb">
        <ul class="la-breadcrumb-list list-inline">
            <li class="la-breadcrumb-item list-inline-item">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <li class="la-breadcrumb-item list-inline-item">
                <span class="separator">»</span>
                Lacak pesanan
            </li>
        </ul>
    </nav>

    <div class="row justify-content-center mt-4">
        <div class="col-12 px-xs-0">
            <div class="shadow-sm bg-white p-4 rounded">
                <b>Lacak pesanan</b>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="lastore-alert lastore-alert-primary mt-4 shadow-sm">
                            <div class="title">Info</div>
                            <div class="rows">
                                <div class="body col-8s">
                                    Untuk melakukan Lacak pesanan, silahkan masukkan no invoice kamu. perlu diketahui
                                    kami juga mengirim realtime pengiriman melalui no WhatsApp kamu
                                </div>
                            </div>
                            <div class="icon">
                                <img src="{{ asset('/svg/undraw_package_arrived_63rf.svg') }}" alt="Konfirmasi bayar"
                                    width="100%">
                            </div>
                        </div>
                        <form action="" method="get" class="form-lacak">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input required type="text" class="form-control" name="invoice"
                                    placeholder="Ketikkan nomor invoice" aria-label="Ketikkan nomor invoice"
                                    aria-describedby="invoice" id="invoice">
                            </div>
                            <button class="btn btn-primary btn-submit mb-3">Lacak</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered table-lacak" style="display: none">
                            <thead>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>Tanggal</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')

<script>
    let btnSubmit = $('.btn-submit');
    $('.form-lacak').on('submit', async function (e) {
        e.preventDefault();
        let invoice = $('#invoice').val();
        if (!invoice) return alert('Isikan invoice dahulu!');
        $('.table-lacak').hide();
        btnSubmit.attr('disabled', 'disabled');
        btnSubmit.html('Mohon tunggu...')
        await searchLacak(invoice);
        btnSubmit.removeAttr('disabled');
        btnSubmit.html('Lacak')
    })
    async function searchLacak(invoice) {
        let raw = await fetch(`${BASE_URL_API}/lacak-order/${invoice}`, {
            headers: {
                'accept': 'application/json',
            },
        });

        let result = await raw.json();

        if (!result.success) {
            return new Snackbar(result.message);
        }
        $('.table-lacak').show();
        let html = null;
        for (const item of result.data) {
            let date = new Date(item.created_at);
            date = date.toLocaleString('id');
            html += `
            <tr>
                <td>${item.keterangan}</td>
                <td>${date}</td>
            </tr>
            `;
        }

        if (!html) {
            html += `
            <tr>
                <td colspan="2" align="center">Belum ada record</td>
            </tr>
            `;
        }

        $('table tbody').html(html);

        console.log(result);

    }

</script>

@endpush
