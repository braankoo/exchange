<?php

namespace BrankoDragovic\Currency\Facade;

use BrankoDragovic\Currency\Exception\CurrencyNotFoundException;
use Illuminate\Support\Facades\Facade;

/**
 * @method static convert(float $amount, string $currency)
*  @throws CurrencyNotFoundException
 */
class Currency extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'currency';
    }
}
