<?php

namespace BrankoDragovic\Currency\Http;

use BrankoDragovic\Currency\Exception\CurrencyNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use \BrankoDragovic\Currency\Facade\Currency;

use OpenApi\Annotations as OA;

class ExchangeController extends BaseController
{
    public function currency(Request $request): JsonResponse
    {
        $request->validate([
            'currency' => 'string|uppercase|required|in:USD,JPY,BGN,CZK,DKK,GBP,HUF,PLN,RON,SEK,CHF,ISK,NOK,TRY,AUD,BRL,CAD,CNY,HKD,IDR,ILS,INR,KRW,MXN,MYR,NZD,PHP,SGD,THB,ZAR',
            'amount' => 'numeric|required'
        ]);

        try {
            $converted = Currency::convert(
                $request->input('amount'),
                $request->input('currency')
            );

            return response()->json([
                'success' => 1,
                'data' => $converted,
                'error' => '',
                'errors' => [],
                'trace' => []
            ], 200);
        } catch (CurrencyNotFoundException $e) {
            return response()->json([
                'success' => 0,
                'data' => [],
                'error' => $e->getMessage(),
                'errors' => [],
                'trace' => []
            ], 200);
        }
    }
}
