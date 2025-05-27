<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use GlobalStatus;

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function countryDeliveryMethod()
    {
        return $this->belongsTo(CountryDeliveryMethod::class);
    }
}
