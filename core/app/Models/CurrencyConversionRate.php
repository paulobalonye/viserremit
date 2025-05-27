<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyConversionRate extends Model
{
    public function toCountry()
    {
        return $this->belongsTo(Country::class, 'to_country');
    }
}
