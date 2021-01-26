<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'deliveries_details';

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
