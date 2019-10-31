<?php

namespace Dsisconeto\LaravelPagSeguro\Invoice;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function customer()
    {
        return $this->morphTo();
    }
}
