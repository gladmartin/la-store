<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WebOption;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    const NO_DISCOUNT = 0.0;

    const ID_CURRENCY = 'Rp ';

    static public function scopeTerlaris($query)
    {
        $query->orderBy('terjual', 'desc');
    }

    public function getTitleAttribute($title)
    {
        $shortCodeJudul = getOption('shortcode_judul');
        if (!$shortCodeJudul) return $title;
        return str_replace(['{%judul%}', '{%harga%}'], [$title, $this->harga], $shortCodeJudul);
    }

    public function getHargaAkhirAttribute()
    {
        $diskon = floatval($this->diskon);
        $hargaDasar = $this->harga;
        if ($diskon === self::NO_DISCOUNT)  return $hargaDasar;
        $hargaDiskon = $hargaDasar - (($hargaDasar * $diskon) / 100);
        return $hargaDiskon;
    }

    public function hargaRupiah($harga)
    {
        return self::ID_CURRENCY . number_format($harga, 0, ',', '.');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function getVariasiAttribute()
    {
        $collection = collect();
        $variants = $this->variants;
        if (!$variants || $variants->isEmpty()) return $collection;

        $variasi = $variants->unique('key');
        foreach ($variasi as $key => $item) {
            $option = [];
            $modelVariasi = $variants->where('key', $item->key);
            foreach ($modelVariasi as $key2 => $value) {
                $option[] = [
                    'name' => $value->value,
                    'model' => $value,
                    'id' => $value->id,
                ];
            }
            $data[] = [
                'name' => $item->key,
                'items' => $option
            ];
        }

        $data = collect($data);

        return $data;
    }

    public function metas()
    {
        return $this->morphMany(Meta::class, 'metaable');
    }
}
