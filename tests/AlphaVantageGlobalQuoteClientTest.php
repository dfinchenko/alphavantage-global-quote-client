<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient\Tests;

use Dfinchenko\AlphaVantageGlobalQuoteClient\AlphaVantageGlobalQuoteClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AlphaVantageGlobalQuoteClientTest extends TestCase
{
    public function testGetQuoteReturnsParsedData()
    {
        $mockResponseBody = [
            'Global Quote' => [
                '01. symbol' => 'IBM',
                '05. price' => '145.00',
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockResponseBody)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockHttpClient = new Client(['handler' => $handlerStack]);

        $client = new AlphaVantageGlobalQuoteClient('fake_api_key', $mockHttpClient);

        $quote = $client->getQuote('IBM');

        $this->assertIsArray($quote);
        $this->assertSame('IBM', $quote['01. symbol']);
        $this->assertSame('145.00', $quote['05. price']);
    }

    public function testThrowsWhenResponseIsInvalid()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['unexpected_key' => 'value'])),
        ]);

        $client = new AlphaVantageGlobalQuoteClient('fake_api_key', new Client(['handler' => HandlerStack::create($mock)]));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unexpected response from AlphaVantage');

        $client->getQuote('IBM');
    }

    public function testThrowsOnNon200Response()
    {
        $mock = new MockHandler([
            new Response(500, [], 'Internal Server Error'),
        ]);

        $client = new AlphaVantageGlobalQuoteClient('fake_api_key', new Client(['handler' => HandlerStack::create($mock)]));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('AlphaVantage returned status code 500');

        $client->getQuote('IBM');
    }
}