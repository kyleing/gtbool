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
     * 添加/更新文章
     * @param $data
     * @return array|bool
     */
    public function addArticle($data)
    {
        //return D($this->tb_article)->upsertBy($data,['id']);
        return D($this->tb_article)->insert($data);
    }

    public function getArticleContent($id)
    {
        return D($this->tb_article)->findById($id);
    }
}
