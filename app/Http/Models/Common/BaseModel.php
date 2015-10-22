<?php namespace App\Http\Models\Common;
use Illuminate\Database\Eloquent\Model;


/**
 * BaseModel:
 * @date 14-4-3
 * @time 下午3:01
 * @author Ray.Zhang <zgh@lansee.net>
 **/
abstract class BaseModel extends Model {

    //todo use public static member var instead of
    /**
     *
     * table define
     */
    protected $tb_feedback = 'feedback'; //反馈表
    protected $tb_event = 'event'; //用户计划表
    protected $tb_user = 'user'; //用户表
    protected $tb_theme = 'theme'; //主题表
    protected $tb_theme_category = 'theme_category';
    protected $tb_admin_user = 'admin_user'; //管理员用户表

    /**
     * 返回错误信息
     * @param $message
     * @param int $code
     * @return array
     */
    static function _error($message, $code = 12000)
    {
        return ['__code' => $code, '__message' => $message];
    }

}