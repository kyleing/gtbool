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
                $tag = $data['tag'] ? explode(',',$data['tag']) : [];
                return view('homepage.blog.article')->with([
                    'data' => $data,
                    'tag' => $tag
                ]);
            }
        }
        else
        {
            //todo view not found
        }
    }

    /*
     * 获取博文目录
     *
     */
    public function getCatalog()
    {
        $page = Input::get('page',1);

        $list = $this->M_article->getArticletList([],$page);

        $pageInfo['count'] = $this->M_article->countArticle([]);

        return view('homepage.blog.catalog')
            ->with([
                'data' => $list,
                'pageInfo' => $pageInfo
            ]);
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

        $tag = array_get($data,'tag','');

        $new_tag_data = explode(',',$tag);

        //$old_tag_data = $this->M_article->getTag();

        $old_tag = $this->M_article->getTag();

        //判断该标签是否为新标签
        $new_tag = array_diff($new_tag_data,$old_tag);

        //如果是新标签,则创建该标签
        if(!empty($new_tag))
        {
            $new_tag = implode(',',$new_tag);
            $this->M_article->addTag($new_tag);
        }

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

    public function getInfo()
    {
        $tag = $this->M_article->getTag();
        $time = $this->M_article->getCreateTime();

        $data = [
            'tag' => $tag,
            'time' => $time
        ];

        return $data;

    }
}