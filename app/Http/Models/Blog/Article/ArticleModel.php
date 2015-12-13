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
        $data = array_filter($data);
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

    /**
     * 统计文章数
     * @param array $conds
     * @return mixed
     */
    public function countArticle($conds = [])
    {
        return D($this->tb_article)->rows($conds);
    }

    /**
     * 标签列表
     * @return mixed
     */
    public function getTag()
    {
        $tag = D($this->tb_tag)->findByOne([])['name'];
        $tag = $tag ? explode(',',$tag) : [];
        return $tag;
    }


    /**
     * 增加标签
     * @param string $name
     * @return array|bool
     */
    public function addTag($name = '')
    {
        $o_tag = D($this->tb_tag)->findByOne([]);

        $data['name'] = $name;

        if($o_tag)
        {
            $data['name'] = $o_tag['name'] . ',' . $name;
            $data['id'] = $o_tag['id'];
            return D($this->tb_tag)->upsertById($data);
        }

        return D($this->tb_tag)->insert($data);
    }

    public function getCreateTime()
    {
        //todo filter delete article
        $article = D($this->tb_article)->orderBy('id','desc')->findBy([],['created_at']);
        $time = [];
        if($article)
        {
            foreach($article as $v)
            {
                //格式化创建时间
                $time[] = date('F Y',strtotime($v['created_at']));
            }

            //去重
            $time = array_unique($time);
        }

        return $time;
    }

}
