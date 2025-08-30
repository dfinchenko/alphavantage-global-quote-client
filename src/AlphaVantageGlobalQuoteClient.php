<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

final class AlphaVantageGlobalQuoteClient implements AlphaVantageGlobalQuoteClientInterface
{
    private const string BASE_URL = 'https://www.alphavantage.co/query';

    public function __construct(
        readonly private string $apiKey,
        readonly private ClientInterface $httpClient
    ) {}

    /**
     * Get latest price (Quote endpoint)
     *
     * @param string $symbol
     * @return array
     */
    public function getQuote(string $symbol): array
    {
        try {
            $response = $this->httpClient->request('GET', self::BASE_URL, [
                'query' => [
                    'function' => 'GLOBAL_QUOTE',
                    'symbol' => $symbol,
                    'apikey' => $this->apiKey,
                ],
                'http_errors' => false,
            ]);
        } catch (GuzzleException $e) {
            throw new RuntimeException('HTTP request to AlphaVantage failed', 0, $e);
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new RuntimeException("AlphaVantage returned status code $statusCode");
        }

        $body = json_decode((string) $response->getBody(), true);

        if (!isset($body['Global Quote'])) {
            throw new RuntimeException('Unexpected response from AlphaVantage: ' . json_encode($body));
        }

        return $body['Global Quote'];
    }
}