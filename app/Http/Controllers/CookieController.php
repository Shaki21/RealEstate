<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CookieController extends Controller
{
    public function setCookie(){
        $response = response('Cookie created successfully!');
        $response->withCookie('cookie_consent', Str::uuid(), 1);
        return $response;
    }

    public function getCookie()
    {
        return request()->cookie('cookie_consent');
    }

    public function delCookie()
    {
        return response('deleted')->cookie('cookie_consent', null, -1);
    }
}
