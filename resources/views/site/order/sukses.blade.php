@extends('layouts.app')

@section('title', 'Detail pesanan')

@push('meta')
<meta property="og:image" content="{{ asset('storage/' . $webOption->get('logo')) }}" />
<meta property="og:title" content="Detail pesanan" />
<meta property="og:description" content="{{ $webOption->get('site_description') }}" />
@endpush()

@push('css')
<style type="text/css">
    .bg-muda {
        background: #f0f0f0 !important;
    }

    .wrapper-bank {
        border: 2px solid #f5f4f4;
        border-radius: 10px;
        padding: 10px;
    }

    .wrapper-bank .bank-logo {
        padding-bottom: 7.5px;
        margin-bottom: 7.5px;
        border-bottom: 1px solid #f5f4f4;
    }
    .detail-pesanan {
        display: none;
    }
    .detail-pesanan.tampil {
        display: block;
    }

</style>
@endpush

@section('content')
<!-- cart-main-area start -->
<div class="cart-main-area pt-5 pb-3 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-uppercase text-danger font-weight-light">Terimakasih</h2>
                <h4>{{ $order->nama }}</h4>
                <p>Telah melakukan pemesanan di website kami</p>
                <div class="row justify-content-center">
                    <div class="table-responsive col-lg-6">
                        <table class="table table-bordered detail-pesanan">
                            <tr align="left">
                                <th>Item</th>
                                <th width="150px">Harga</th>
                            </tr>
                            <tr align="left">
                                <td>
                                    {{ $order->product->title ?? 'Produk tidak tersedia' }}
                                    <br>
                                    <div class="text-gray" style="font-size: 11px;font-weight:300">
                                        (Qty. {{ $order->kuantitas }})
                                    </div>
                                </td>
                                <td>{{ rupiah($order->bayar) }}</td>
                            </tr>
                            <tr align="left">
                                <td>
                                    Ongkir
                                    <br>
                                    <div class="text-gray" style="font-size: 11px;font-weight:300">
                                        ({{ strtoupper($order->delivery->ekspedisi) }}
                                        {{ $order->delivery->service }})
                                    </div>
                                </td>
                                <td>{{ rupiah($order->delivery->ongkos_kirim) }}</td>
                            </tr>
                            <tr align="left" class="bg-muda">
                                <th>TOTAL</th>
                                <th>{{ rupiah($order->delivery->ongkos_kirim + $order->bayar) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <a href="" class="text-uppercase btn-detail-pesanan">Detail pesanan</a>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="bg-muda">
                            <h2 class="mb-0 p-2 text-center font-weight-bold text-uppercase h4">NO INVOICE :
                                {{ $order->invoice }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-muda">
                            <h2 class="h4 mb-0 p-2 text-center font-weight-bold text-uppercase">TOTAL : {{ rupiah($order->delivery->ongkos_kirim + $order->bayar) }}</h2>
                        </div>
                    </div>
                </div>
                <p class="bg-danger text-white text-center p-1 mb-1 mt-3">Segera lakukan pembayaran Anda sebelum tanggal
                    : <span class="font-weight-bold"> {{ $order->created_at->addHours(24)->format('d M Y') }}</span> jam
                    <span class="font-weight-bold"> {{ $order->created_at->addHours(24)->format('H:i') }} WIB</span></p>

                <div class="row justify-content-center mt-5 list-bank" style="width: 100%;">
                    @foreach ($banks as $item)
                    @php
                        $bank = $item->metas->where('key', 'bank')->first()->value;
                        $noRek = $item->metas->where('key', 'no_rek')->first()->value;
                        $atasNama = $item->metas->where('key', 'atas_nama')->first()->value;
                        $rakit = $bank . ' - ' . $noRek . ' Atas nama ' . $atasNama;
                    @endphp
                    <div class="col-sm-6 col-lg-3">
                        <div class="wrapper-bank bg-white" align="center">
                            <div class="wrapper-image bank-logo">
                                <img width="100" src="{{ image($item->image) }}" alt="{{ $bank }}">
                            </div>
                            <p class="mb-0 font-weight-bold ">{{ $atasNama }}</p>
                            <input style="width:100%;border:none"
                                class="text-center mb-0 font-weight-light h5 text-{{ $noRek }}"
                                value="{{ $noRek }}" readonly="">
                            <button type="button" class="btn btn-sm py-1 btn-default"
                                onclick="toClip('.text-{{ $noRek }}','')">Salin/Copy</button>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <p>Harap transfer sesuai dengan nominal <b>"TOTAL" </b> ke salah satu bank diatas!</p> <br>
                    <p class="mb-0">Setelah transfer , Segera <b>Konfirmasi Pembayaran. </b> Perbedaan nilai transfer akan menghambat proses verifikasi!</p>
                    <div class="col-12">
                        <a class="btn btn-lg btn-primary btn-konfirmasi mb-3"
                            href="{{ route('order.konfirmasi', 'invoice=' . $order->invoice) }}">Konfirmasi Pembayaran</a>
                    </div>

                    <br>
                    <p class="text-danger">Pemesanan dianggap batal jika tidak melakukan pembayaran selama 24 jam</p>
                    <p class="font-weight-bold">Kami juga telah mengirimkan invoice ini ke nomor WhatsApp kamu ya.</p>
                    <a class="text-dark" href="{{ url('') }}">&lt;&lt; Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->
@endsection

@push('js')
<script type="text/javascript">
    function toClip(el, text) {
        var copyText = $(el);
        copyText.select();
        document.execCommand("copy");
        if (text != '') {
            alert(text);
        }
    }
    $('.btn-detail-pesanan').on('click', function(e) {
        e.preventDefault();
        $('.detail-pesanan').toggleClass('tampil');
    })
</script>
@endpush
