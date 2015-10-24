<?php namespace App\Http\Controllers\Blog\Article;
use App\Http\Controllers\BaseController;
use App\Http\Models\Blog\Article\ArticleModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-24
 * Time: 下午8:47
 */
class ArticleController extends BaseController
{
    //文章ID
    private $id = '';

    //实例化文章对象
    private $M_article;

    public function __construct()
    {
        $this->id = Input::get('id','');
        $this->M_article = new ArticleModel();
    }



    /**
     * 博文展示页
     *
     */
    public function getIndex()
    {
        if($this->id)
        {
            $data = $this->M_article->getArticleContent($this->id);
            if($data)
            {
                return view('homepage.blog.article')->with([
                    'data' => $data
                ]);
            }
        }
        else
        {
            //todo view not found
        }
    }

    /**
     * 博客编辑页
     *
     */
    public function getEdit()
    {
        return view('homepage.blog.edit');
    }

    /**
     * 提交编辑
     *
     */
    public function postEdit()
    {
        $data = Input::all();

        if($this->id)
        {
            //todo update actile
        }
        else
        {
            //todo validate $data
            $data['created_at'] = date('Y-m-d H:i:s');

            $res = $this->M_article->addArticle($data);
            if($res)
            {
                return Redirect::to('/blog/article?id=' . $res['id']);
            }
        }
    }
}