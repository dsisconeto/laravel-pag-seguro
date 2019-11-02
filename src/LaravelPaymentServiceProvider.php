<?php

namespace Dsisconeto\LaravelPayment;

use Illuminate\Support\ServiceProvider;

class LaravelPaymentServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/*' => database_path('migrations'),
        ], 'migrations');
    }

}
