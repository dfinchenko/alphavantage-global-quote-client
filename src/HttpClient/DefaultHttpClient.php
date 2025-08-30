<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient\HttpClient;

use RuntimeException;

final class DefaultHttpClient implements HttpClientInterface
{
    public function get(string $url, array $options = []): string
    {
        $query = isset($options['query']) ? '?' . http_build_query($options['query']) : '';
        $fullUrl = $url . $query;

        $contextOptions = [
            'http' => [
                'method' => 'GET',
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($contextOptions);
        $result = @file_get_contents($fullUrl, false, $context);

        if ($result === false) {
            $error = error_get_last();
            throw new RuntimeException('HTTP request failed: ' . ($error['message'] ?? 'unknown error'));
        }

        return $result;
    }
}