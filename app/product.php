<?php

namespace App;
use App\cart;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
