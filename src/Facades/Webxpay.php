<?php
namespace Isurindu\WebxpayLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Webxpay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'webxpay';
    }
}
