# Webxpay Laravel

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

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Isurindu\WebxpayLaravel\WebxpayServiceProvider" --tag="config"
```

You can publish the views file with:

```bash
php artisan vendor:publish --provider="Isurindu\WebxpayLaravel\WebxpayServiceProvider" --tag="views"
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
                'first_name'=>'',
                'last_name'=>'',
                'email'=>'',
                'contact_number'=>'',
                'address_line_one'=>'',
                'cms'=>'',
                'process_currency'=>'',
                'custom_fields'=>'',
                'city'=>'',
                'state'=>'',
                'postal_code'=>'',
                'country'=>'',
            ]);

    }
    public function verify(Request $request)
    {
        return dd(Webxpay::verify());
    }
}
```
