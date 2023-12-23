<?php
declare(strict_types=1);

namespace App\Api;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyRates
{
    private const API = 'https://api.coinbase.com/v2/exchange-rates?currency=';
    private string $baseCurrency;
    private string $targetCurrency;

    public static function getRate(string $baseCurrency, string $targetCurrency): float
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=' . $baseCurrency);
            $response = json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            throw new Exception('Unable to process request');
        }
        return floatval($response->data->rates->{$targetCurrency});
    }
}
