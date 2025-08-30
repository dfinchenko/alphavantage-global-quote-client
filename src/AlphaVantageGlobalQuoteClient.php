<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient;

use Dfinchenko\AlphaVantageGlobalQuoteClient\HttpClient\HttpClientInterface;
use RuntimeException;

final class AlphaVantageGlobalQuoteClient implements AlphaVantageGlobalQuoteClientInterface
{
    private const string BASE_URL = 'https://www.alphavantage.co/query';

    public function __construct(
        private readonly string $apiKey,
        private readonly HttpClientInterface $httpClient
    ) {}

    public function getQuote(string $symbol): array
    {
        $responseBody = $this->httpClient->get(self::BASE_URL, [
            'query' => [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $symbol,
                'apikey' => $this->apiKey
            ],
        ]);

        $body = json_decode($responseBody, true);

        if (!isset($body['Global Quote'])) {
            throw new RuntimeException('Unexpected response from AlphaVantage: ' . json_encode($body));
        }

        return $body['Global Quote'];
    }
}