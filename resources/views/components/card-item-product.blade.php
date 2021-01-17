<div class="col-lg-3 col-6 mb-5">
    <a href="{{ route('product.single', [$item->slug, $item->id]) }}">
        <div class="card__product shadow-sm">
            <img src="{{ $item->image }}" alt="">
            <div class="p-3">
                <a href="{{ route('product.single', [$item->slug, $item->id]) }}"
                    class="card__product__title">{{ $item->title }}</a>
                <div>
                    @if ($item->diskon > 0)
                    <div class="diskon">
                        <span class="badge badge-danger">{{ $item->diskon }}%</span>
                        <span class="harga-dasar">{{ rupiah($item->harga) }}</span>
                    </div>
                    @endif
                    <div class="harga-akhir mt-2">{{ rupiah($item->harga_akhir) }}</div>
                </div>
            </div>
        </div>
    </a>
</div>
