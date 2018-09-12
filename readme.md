# Webxpay Laravel

[![Latest Stable Version](https://poser.pugx.org/isurindu/webxpay-laravel/v/stable)](https://packagist.org/packages/isurindu/webxpay-laravel)
[![Total Downloads](https://poser.pugx.org/isurindu/webxpay-laravel/downloads)](https://packagist.org/packages/isurindu/webxpay-laravel)
[![License](https://poser.pugx.org/isurindu/webxpay-laravel/license)](https://packagist.org/packages/isurindu/webxpay-laravel)

### Installation

You can install the package via composer:

```bash
composer require isurindu/webxpay-laravel
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    Isurindu\WebxpayLaravel\WebxpayServiceProvider::class,
];
```

You can publish config and views

```bash
php artisan vendor:publish --provider="Isurindu\WebxpayLaravel\WebxpayServiceProvider"
```

## Usage

in route

```php
Route::get('payment/{ORDER_ID}', 'PaymentController@index');
Route::post('payment/verify', 'PaymentController@verify');
```

in App/Http/Middleware/VerifyCsrfToken.php

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'payment/verify'
    ];
}
```

in controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Isurindu\WebxpayLaravel\Facades\Webxpay;

class PaymentController extends Controller
{

    public function store(Request $request)
    {

            return Webxpay::redirect([
                'order_id'=>'102',
                'price'=>'100',
                'first_name'=>'isurindu',
                'last_name'=>'prabashwara',
                'email'=>'hello@isurindu.com',
                'contact_number'=>'',
                'address_line_one'=>'',
                'cms'=>'laravel',
                'process_currency'=>'LKR',
                'custom_fields'=>'',
                'city'=>'',
                'state'=>'',
                'postal_code'=>'',
                'country'=>'',
                'return_url'=>'http://yourdomain.com/payment-verify',

            ]);

    }
    public function verify(Request $request)
    {
        return dd(Webxpay::verify());
    }
}
```
