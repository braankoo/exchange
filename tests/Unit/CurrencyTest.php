<?php

namespace BrankoDragovic\Currency\Tests\Unit;

use BrankoDragovic\Currency\Currency;
use BrankoDragovic\Currency\Exception\CurrencyNotFoundException;
use BrankoDragovic\Currency\Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;

class CurrencyTest extends TestCase
{
    public function testConvert(): void
    {
        $httpClientMock = $this->createMock(ClientInterface::class);
        $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?>
            <gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
                <gesmes:subject>Reference rates</gesmes:subject>
            <gesmes:Sender>
            <gesmes:name>European Central Bank</gesmes:name>
            </gesmes:Sender>
            <Cube>
                <Cube time="2023-04-05">
                    <Cube currency="USD" rate="1.174"/>
                    <Cube currency="GBP" rate="0.852"/>
                    <Cube currency="JPY" rate="128.109"/>
                </Cube>
            </Cube>
            </gesmes:Envelope>
        ');
        $httpClientMock->expects($this->once())
            ->method('sendRequest')
            ->willReturn($response);
        $currency = new Currency($httpClientMock);
        $result = $currency->convert(10, 'usd');
        $this->assertEquals(11.74, $result);
    }

    public function testConvertWithUnknownCurrency(): void
    {
        $this->expectException(CurrencyNotFoundException::class);
        $httpClientMock = $this->createMock(ClientInterface::class);
        $response = new Response(200, [], '<gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
                <gesmes:subject>Reference rates</gesmes:subject>
            <gesmes:Sender>
            <gesmes:name>European Central Bank</gesmes:name>
            </gesmes:Sender>
            <Cube>
                <Cube time="2023-04-05">
                    <Cube currency="USD" rate="1.174"/>
                    <Cube currency="GBP" rate="0.852"/>
                    <Cube currency="JPY" rate="128.109"/>
                </Cube>
            </Cube>
            </gesmes:Envelope>
');
        $httpClientMock->expects($this->once())
            ->method('sendRequest')
            ->willReturn($response);
        $currency = new Currency($httpClientMock);
        $currency->convert(10, 'xyz');
    }
}
