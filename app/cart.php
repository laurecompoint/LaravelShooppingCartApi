<?php

namespace App;
use App\product;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
