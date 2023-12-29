<?php
declare(strict_types=1);

namespace App\Api;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class CurrencyRates
{
    public static function getRate(string $baseCurrency, string $targetCurrency): float
    {
        $response = self::Connect($baseCurrency);
        return floatval($response->data->rates->{$targetCurrency});
    }

    public static function getAssets(string $baseCurrency): stdClass
    {
        $response = self::Connect($baseCurrency);
        return $response->data->rates;

    }

    private static function Connect(string $baseCurrency): stdClass
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=' . $baseCurrency);
            $response = json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            throw new Exception('Unable to process request');
        }
        return $response;
    }
}
