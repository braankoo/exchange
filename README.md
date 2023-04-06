# Exchange package

## Installation

In root of laravel app create packages folder. ```mdkir packages```

Go to packages and clone this package 
```bash
git clone https://github.com/braankoo/exchange.git
```
In composer.json of Laravel app add
``` "repositories": [
        {
            "type": "path",
            "url": "./packages/exchange"
        }
    ] 
```

Run ``` composer require brankodragovic/currency ```

Please publish all assets ```php artisan vendor:publish --provider="BrankoDragovic\Currency\ServiceProvider\CurrencyServiceProvider" --tag="assets"```

Cache routes ```php artisan route:cache ```

Please change ```"minimum-stability": "dev"``` in composer.json

## Usage
Use as facade
```
Currency::convert(203,"USD");
```
or access:
http://yourhost/_branko/exchange/currency/convert?amount=10&currency=USD

### Testing
Test using swagger:
http://yourhost/_branko/documentation

```bash
composer test
```
