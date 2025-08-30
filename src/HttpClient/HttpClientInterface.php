<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient\HttpClient;

interface HttpClientInterface
{
    /**
     * @param string $url
     * @param array<string, mixed> $options
     * @return string
     */
    public function get(string $url, array $options = []): string;
}