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
        $page_size = 5;

        $list = (new ArticleModel())->getArticletList([],$page,$page_size);


        $pageInfo = [];
        $pageInfo['page'] = $page;
        $pageInfo['count'] = (new ArticleModel())->countArticle();
        $pageInfo['pages'] = ceil($pageInfo['count'] / $page_size);

        if(!empty($list))
        {
            foreach($list as &$v)
            {
                $v['tag'] = explode(',',$v['tag']);
            }
        }

        return view('homepage.blog.index')
            ->with([
                'data' => $list,
                'pageInfo' => $pageInfo
            ]);
    }

}