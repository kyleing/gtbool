<?php namespace App\Http\Controllers\Home;
use App\Http\Controllers\BaseController;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-2
 * Time: 下午6:43
 */
class HomeController extends BaseController
{
    public function index()
    {
        return view('homepage.index');
    }
}