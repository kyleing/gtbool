<?php namespace  App\Http\Controllers\Blog;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-3
 * Time: 上午10:16
 */
class BlogController extends BaseController
{
    public function index()
    {
        return view('homepage.blog.index');
    }

    public function catalogList()
    {
        return view('homepage.blog.catalog');
    }

    public function blogContent()
    {
        return view('homepage.blog.content');
    }
}