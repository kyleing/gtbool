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
        $am = new ArticleModel();
        $page = Input::get('page',1);
        $page_size = 5;

        $list = $am->getArticletList([],$page,$page_size);
        $tag = $am->getTag();


        $pageInfo = [];
        $pageInfo['page'] = $page;
        $pageInfo['count'] = $am->countArticle();
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
                'tag' => $tag,
                'pageInfo' => $pageInfo
            ]);
    }

}