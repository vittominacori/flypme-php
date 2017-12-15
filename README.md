# Flyp.me for PHP

A PHP wrapper for [Flyp.me](https://flyp.me/api) APIs

## Install

```
composer require vittominacori/flypme-php
```


## Usage

### Prepare requirements

```php
require __DIR__ . '/vendor/autoload.php';

use \FlypMe\FlypMe;
```

### Create client

```php
$flypme = new FlypMe();
```

### Call APIs

#### Create

Create a new order

Last param could be "invoiced_amount" or "ordered_amount"

```php
$flypme->orderCreate("LTC", "ZEC", "0.01", "t1SBTywpsDMKndjogkXhZZSKdVbhadt3rVt", "invoiced_amount")
```

result: 

```json
{
    "order": {
        "uuid": "5df90261-6fe5-46ca-bb86-77d1415b24c0",
        "destination": "t1SBTywpsDMKndjogkXhZZSKdVbhadt3rVt",
        "exchange_rate": "0.7327148054",
        "ordered_amount": "0.01",
        "invoiced_amount": "0.01473971",
        "charged_fee": "0.0008",
        "from_currency": "LTC",
        "to_currency": "ZEC"
    },
    "expires": 1199,
    "deposit_address": "MJwm742LPLxiKGawcSv7EWxaQwt1y8MX1P"
}
```

#### Check

Check order status by uuid

Possible statuses are: WAITING_FOR_DEPOSIT, DEPOSIT_RECEIVED, DEPOSIT_CONFIRMED, EXECUTED, REFUNDED, CANCELED and EXPIRED

```php
$flypme->orderCheck("5df90261-6fe5-46ca-bb86-77d1415b24c0")
```

result: 

```json
{
    "status": "WAITING_FOR_DEPOSIT"
}
```

#### Info

Get order full info

```php
$flypme->orderInfo("5df90261-6fe5-46ca-bb86-77d1415b24c0")
```

result: 

```json
{
    "order": {
        "uuid": "5df90261-6fe5-46ca-bb86-77d1415b24c0",
        "destination": "t1SBTywpsDMKndjogkXhZZSKdVbhadt3rVt",
        "exchange_rate": "0.7327148054",
        "ordered_amount": "0.01",
        "invoiced_amount": "0.01473971",
        "charged_fee": "0.0008",
        "from_currency": "LTC",
        "to_currency": "ZEC"
    },
    "expires": 966,
    "status": "WAITING_FOR_DEPOSIT",
    "deposit_address": "MJwm742LPLxiKGawcSv7EWxaQwt1y8MX1P"
}
```

#### Cancel order

Cancel a pending order

```php
$flypme->orderCancel("5df90261-6fe5-46ca-bb86-77d1415b24c0")
```

result: 

```json
{
    "result": "ok"
}
```

#### Query rates

Get exchange rates

```php
$flypme->dataExchangeRates()
```

result: 

```json
{
    "LTC-BTC": "0.0174777496",
    "BTC-LTC": "55.724760293",
    (...)
    "CREA-FYP": "2.06496",
    "FYP-CREA": "0.3423985733"
}
```

#### Query active currencies

Get available currencies information

A currency needs to have both exchange and send set to true to be enabled for the accountless exchange. Confirmation time is the expected time in minutes (approximate). Other parameters are self explanatory.

```php
$flypme->currencies()
```

result: 

```json
{
    "BTC": {
        "code": "BTC",
        "precision": 8,
        "display_precision": 4,
        "created_at": "2014-02-04T02:28:37.000Z",
        "updated_at": "2017-12-12T17:03:52.000Z",
        "name": "Bitcoin",
        "website": "https://bitcoin.org/",
        "confirmation_time": 20,
        "default": false,
        "charged_fee": "0.0008",
        "currency_type": "CRYPTO",
        "exchange": true,
        "send": true
    },
    (...)
    "ZEC": {
        "code": "ZEC",
        "precision": 8,
        "display_precision": 4,
        "created_at": "2017-02-24T11:41:27.000Z",
        "updated_at": "2017-12-12T14:44:02.000Z",
        "name": "Zcash",
        "website": "https://z.cash/",
        "confirmation_time": 5,
        "default": false,
        "charged_fee": "0.0008",
        "currency_type": "CRYPTO",
        "exchange": true,
        "send": true
    }
}
```

#### Query limits

Get max and min values that can be requested

```php
$flypme->orderLimits()
```

result: 

```json
{
    "BTC": {
        "max": "0.59769291",
        "min": "0.00000598"
    },
    "LTC": {
        "max": "33.75289617",
        "min": "0.00033753"
    },
    (...)
    "PIVX": {
        "max": "912.941625",
        "min": "0.02004067"
    },
    "CREA": {
        "max": "14081.33958578",
        "min": "0.26647032"
    }
}
```