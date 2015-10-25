<?php namespace App\Http\Models\Blog\Article;
use App\Http\Models\Common\BaseModel;
use App\Http\Models\Common\SchemaTrait;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-24
 * Time: 下午9:01
 */


class ArticleModel extends BaseModel
{
    use SchemaTrait;

    /**
     * 获取博文目录
     * @param $conds
     * @param int $page
     * @param int $page_size
     * @return mixed
     */
    public function getArticletList($conds = [],$page = 1,$page_size = 10)
    {
       return D($this->tb_article)
           ->page($page,$page_size)
           ->orderBy('id','desc')
           ->findBy($conds);
    }

    /**
     * 添加/更新文章
     * @param $data
     * @return array|bool
     */
    public function addArticle($data)
    {
        return D($this->tb_article)->upsertBy($data,['id']);
    }

    /**
     * 获取博文内容
     * @param $id
     * @return array|null
     */
    public function getArticleContent($id)
    {
        return D($this->tb_article)->findById($id);
    }

    public function countArticle($conds = [])
    {
        return D($this->tb_article)->rows($conds);
    }
}
