<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function metas()
    {
        return $this->morphMany(Meta::class, 'metaable');
    }

    public function getImageAttribute($image)
    {
        return (strpos($image, 'http') === false) ? asset('storage/post/' . $image) : $image;
    }
}
