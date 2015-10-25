<?php namespace  App\Http\Controllers\Blog;
use App\Http\Controllers\BaseController;
use App\Http\Models\Blog\Article\ArticleModel;
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
        $page = Input::get('page',1);

        $list = (new ArticleModel())->getArticletList([],$page);

        $pageInfo = (new ArticleModel())->countArticle();

        return view('homepage.blog.index')
            ->with([
                'data' => $list,
                'pageInfo' => $pageInfo
            ]);
    }

}