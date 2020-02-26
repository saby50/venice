<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'callback','admin/api/applogin','admin/api/getdata','admin/api/get_food_data','admin/api/gettoken','api/get_recive_payment','api/check_otp','admin/api/forgotpin','admin/api/unit_refund','admin/api/change_food_status','admin/api/refund_food'
    ];
}
