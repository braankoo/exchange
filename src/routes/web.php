<?php

use Illuminate\Support\Facades\Route;
use BrankoDragovic\Currency\Http\ExchangeController;

Route::get(
    '_branko/exchange/currency/convert',
    [ExchangeController::class, 'currency']
);

Route::view(
    '_branko/documentation',
    'currency::swagger'
);
