[![Tests](https://github.com/dfinchenko/alphavantage-global-quote-client/actions/workflows/tests.yml/badge.svg)](https://github.com/dfinchenko/alphavantage-global-quote-client/actions)
[![codecov](https://codecov.io/gh/dfinchenko/alphavantage-global-quote-client/branch/main/graph/badge.svg)](https://codecov.io/gh/dfinchenko/alphavantage-global-quote-client)
[![License](https://img.shields.io/github/license/dfinchenko/alphavantage-global-quote-client.svg)](LICENSE)

# AlphaVantage Global Quote Client
A simple and lightweight PHP client for the [Alpha Vantage API](https://www.alphavantage.co/documentation/), designed specifically to fetch real-time stock data using the **Global Quote** endpoint.

---

## 🚀 Features
- Fetch stock quote data (symbol, price, etc.)
- PHP 8.3+ compatible
- Unit tested and easy to integrate
- PSR-4 autoloading

---

## 📋 Requirements

- **PHP**: Version 8.3 or higher
- **Guzzle HTTP**: For making HTTP requests

---

## 📦 Installation
```bash
composer require yourname/alphavantage-global-quote-client
```

## ⚙️ Usage
To use the AlphaVantageGlobalQuoteClient, first install the package via Composer, then create an instance of the client with your API key: (https://www.alphavantage.co/documentation/)

```php
use Alphavantage\AlphaVantageGlobalQuoteClient;

// Initialize the client with your API key
$client = new AlphaVantageGlobalQuoteClient('your_api_key');

// Fetch the quote for a stock symbol (e.g., AAPL)
$quote = $client->getQuote('AAPL');

// Print the result
print_r($quote);

/*
Array
(
    [01. symbol] => AAPL
    [05. price] => 195.57
    // Other fields
)
*/
```

## 🧪 Testing

To run tests for this package, make sure you have [PHPUnit](https://phpunit.de/) installed. Then, run the following command:

```bash
./vendor/bin/phpunit
```