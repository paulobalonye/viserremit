<?php

namespace App\Lib;

use App\Models\Country;
use App\Models\CurrencyConversionRate;
use Exception;

class ConversionRate
{

    private $conversionConfig;
    private $provider;
    private $countries;
    public $exceptions = false;
    public function __construct()
    {
        $gs                     = gs();
        $conversionConfig       = $gs->conversion_rate_api;
        $this->provider         = @$conversionConfig?->provider;
        $this->conversionConfig = $conversionConfig;
        $this->countries = Country::active()->get();
    }
    function synchronizeAll()
    {
        $conversionConfig = $this->conversionConfig;
        if (!@$conversionConfig->status) return;
        $countries = $this->countries;
        foreach ($countries ?? [] as $country) {
            $this->sync($country);
        }
    }

    function sync($country)
    {
        $this->{$this->provider}($country);
    }

    function exchangerate($fromCountry)
    {
        if (!$fromCountry) return;
        $baseCurrency = strtoupper($fromCountry->currency);
        $apiKey       = @$this->conversionConfig?->exchangerate?->api_key;
        $url          = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$baseCurrency";
        $response     = CurlRequest::curlContent($url);
        $response     = json_decode($response ?? '[]');
        if (!@$response->conversion_rates) {
            if ($this->exceptions) {
                $notification = 'Wrong API credentials or currency code. Please verify.';
                if (@$response?->result == "error" && @$response?->{"error-type"}) {
                    $notification =  'API ERROR: ' . keyToTitle(@$response?->{"error-type"});
                }
                throw new Exception($notification);
            }
            return;
        }
        $rates = @$response?->conversion_rates;

        $countries = $this->countries;
        foreach (@$countries?->where('id', "!=", $fromCountry->id) ?? [] as $toCountry) {
            $conversion      = CurrencyConversionRate::where('from_country', $fromCountry->id)->where('to_country', $toCountry->id)->first();
            if (!$conversion) {
                $conversion = new CurrencyConversionRate();
                $conversion->from_country = $fromCountry->id;
                $conversion->to_country = $toCountry->id;
            }
            $toCurrency      = strtoupper($toCountry->currency);
            $toCountry->rate = $this->adjustRates(@$rates?->{$toCurrency});
            $toCountry->save();
        }
    }
    function currencyapi($fromCountry)
    {
        if (!$fromCountry) return;
        $baseCurrency = strtoupper($fromCountry->currency);

        $apiKey       = @$this->conversionConfig?->currencyapi?->apikey;
        $url          = "https://api.currencyapi.com/v3/latest?apikey=$apiKey&base_currency=$baseCurrency";
        $response     = CurlRequest::curlContent($url);
        $response     = json_decode($response ?? '[]');
        if (!@$response->data) {
            if ($this->exceptions) {
                $notification = 'Wrong API credentials or currency code. Please verify.';
                if (@$response?->errors && @$response?->message) {
                    $notification =  'API ERROR: ' . @$response?->message;
                }
                throw new Exception($notification);
            }
            return;
        }
        $rates = @$response?->data;

        $countries = $this->countries;
        foreach (@$countries?->where('id', "!=", $fromCountry->id) ?? [] as $toCountry) {
            $conversion      = CurrencyConversionRate::where('from_country', $fromCountry->id)->where('to_country', $toCountry->id)->first();
            if (!$conversion) {
                $conversion               = new CurrencyConversionRate();
                $conversion->from_country = $fromCountry->id;
                $conversion->to_country   = $toCountry->id;
            }
            $toCurrency       = strtoupper($toCountry->currency);
            $conversion->rate = $this->adjustRates(@$rates?->{$toCurrency}->value);
            $conversion->save();
        }
    }
    function openexchangerates($fromCountry)
    {
        if (!$fromCountry) return;
        $baseCurrency = strtoupper($fromCountry->currency);
        $appId        = @$this->conversionConfig?->openexchangerates?->app_id;
        $url          = "https://openexchangerates.org/api/latest.json?app_id=$appId&base=$baseCurrency";
        $response     = CurlRequest::curlContent($url);
        $response     = json_decode($response ?? '[]');
        if (!@$response?->rates) {
            if ($this->exceptions) {
                $notification = 'Wrong API credentials or currency code. Please verify.';
                if (@$response?->error && @$response?->description) {
                    $notification = @$response?->description;
                }
                throw new Exception($notification);
            }
            return;
        }
        $rates = @$response?->rates;

        $countries = $this->countries;
        foreach (@$countries?->where('id', "!=", $fromCountry->id) ?? [] as $toCountry) {
            $conversion      = CurrencyConversionRate::where('from_country', $fromCountry->id)->where('to_country', $toCountry->id)->first();
            if (!$conversion) {
                $conversion = new CurrencyConversionRate();
                $conversion->from_country = $fromCountry->id;
                $conversion->to_country = $toCountry->id;
            }
            $toCurrency      = strtoupper($toCountry->currency);
            $conversion->rate = $this->adjustRates(@$rates?->{$toCurrency});
            $toCountry->save();
        }
    }
    function adjustRates($rate)
    {
        $conversionConfig = $this->conversionConfig;
        $fixedCharge      = floatval(@$conversionConfig?->fixed_adjustment ?? 0);
        $percentRate      = floatval(@$conversionConfig?->percent_adjustment ?? 0);
        return $rate + $fixedCharge + $percentRate * $rate / 100;
    }

    public static function providers()
    {
        $providers = [];
        $providers['openexchangerates'] = [
            "name" => "Open Exchange Rates",
            "url"  => "https://openexchangerates.org/"
        ];
        $providers['currencyapi'] = [
            "name" => "Currency Api",
            "url"  => "https://app.currencyapi.com"
        ];
        $providers['exchangerate'] = [
            "name" => "Exchange Rate Api",
            "url"  => "https://www.exchangerate-api.com/"
        ];
        return $providers;
    }
}
