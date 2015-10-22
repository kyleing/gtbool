<?php namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-2
 * Time: 下午6:54
 */

class BaseController extends Controller
{
    protected function isAuth()
    {
        return Auth::check();
    }
}