<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * page home
     * @param Request $request
     * @return mixed
     */

    public function index(Request $request)
    {
        return view('client/pages/home');
    }
}
