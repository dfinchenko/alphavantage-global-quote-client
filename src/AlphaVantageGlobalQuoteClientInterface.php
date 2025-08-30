<?php

namespace Dfinchenko\AlphaVantageGlobalQuoteClient;

interface AlphaVantageGlobalQuoteClientInterface
{
    /**
     * Get latest price (Quote endpoint)
     *
     * @param string $symbol
     * @return array
     */
    public function getQuote(string $symbol): array;
}