<?php
/**
 * FlypMe PHP
 *
 * @link      https://github.com/vittominacori/flypme-php
 * @author    Vittorio Minacori (https://github.com/vittominacori)
 * @license   https://github.com/vittominacori/flypme-php/blob/master/LICENSE (MIT License)
 */
namespace FlypMe;

use Unirest;

class FlypMe
{
    private static $endpoint = "https://flyp.me/api/v1/";
    private static $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function __construct($endpoint = '', $headers = [])
    {
        if (!empty($endpoint)) {
            self::$endpoint = $endpoint;
        }
        if (!empty($headers)) {
            self::$headers = $headers;
        }
    }

    // public methods

    public function currencies()
    {
        return $this->get('currencies');
    }

    public function dataExchangeRates()
    {
        return $this->get('data/exchange_rates');
    }

    public function orderLimits()
    {
        return $this->post('order/limits');
    }

    public function orderCreate($from_currency, $to_currency, $ordered_amount, $destination)
    {
        $body = [
            "order" => [
                "from_currency" => $from_currency,
                "to_currency" => $to_currency,
                "ordered_amount" => $ordered_amount,
                "destination" => $destination
            ]
        ];
        return $this->post('order/create', $body, 'json');
    }

    public function orderCheck($uuid)
    {
        $body = [
            "uuid" => $uuid
        ];
        return $this->post('order/check', $body, 'json');
    }

    public function orderInfo($uuid)
    {
        $body = [
            "uuid" => $uuid
        ];
        return $this->post('order/info', $body, 'json');
    }

    public function orderCancel($uuid)
    {
        $body = [
            "uuid" => $uuid
        ];
        return $this->post('order/cancel', $body, 'json');
    }

    // private methods

    private function get($method, $parameters = [])
    {
        $apiCall = self::$endpoint . $method;
        $response = Unirest\Request::get($apiCall, self::$headers, $parameters);

        if ($response->code == 200) {
            return $response->body;
        }
        return $response;
    }

    private function post($method, $body = [], $type = '')
    {
        $apiCall = self::$endpoint . $method;

        if ($type == 'json') {
            $body = Unirest\Request\Body::json($body);
        }

        $response = Unirest\Request::post($apiCall, self::$headers, $body);

        if ($response->code == 200) {
            return $response->body;
        }
        return $response;
    }
}
