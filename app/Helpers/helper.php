<?php

/*
|--------------------------------------------------------------------------
| Helper Activation Instructions
|--------------------------------------------------------------------------
|
| To enable this global helper function, add the following to your
| composer.json file inside the "autoload" section:
|
| "files": [
|     "app/Helpers/helper.php"
| ]
|
| After updating composer.json, run the following command:
|
| composer dump-autoload
|
| This will register the helper function globally in your Laravel app.
|
*/

if (!function_exists('to_money')) {
    function to_money(?float $amount, string $currency = 'PHP'): string
    {
        $amount ??= 0;

        $symbols = [
            'PHP' => '₱',
            'USD' => '$',
            'JPY' => '¥',
            'CNY' => '¥',
            'GBP' => '£',
            'RUB' => '₽',
            'EUR' => '€',
            'INR' => '₹',
            'THB' => '฿',
            'PYG' => '₲',
            'GHS' => '₵',
        ];

        $symbol = $symbols[$currency] ?? $symbols['PHP'];

        return $symbol . number_format($amount, 2, '.', ',');
    }
}
