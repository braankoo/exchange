<?php

namespace BrankoDragovic\Currency;

use BrankoDragovic\Currency\Exception\CurrencyNotFoundException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class Currency
{
    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws CurrencyNotFoundException|ClientExceptionInterface
     */
    public function convert(float $amount, string $currency): string
    {
        $response = $this->httpClient->sendRequest(
            new Request('GET', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
        );
        $xml = simplexml_load_string($response->getBody()->__toString());

        $response = json_decode(json_encode($xml), true);
        $currencies = $response['Cube']['Cube']['Cube'];

        $currency = $this->getCurrencyRate($currencies, $currency);

        if (!$currency) {
            throw new CurrencyNotFoundException('Currency not founded', 404);
        }
        $rate = array_values($currency)[0]['@attributes']['rate'];

        return number_format($rate * $amount,2);
    }

    /**
     * @param array $currencies
     * @param string $currency
     * @return array
     */
    private function getCurrencyRate(array $currencies, string $currency): array
    {
        return array_filter(
            $currencies,
            fn($single) => $single['@attributes']['currency'] == strtoupper(
                    $currency
                )
        );
    }
}
