<?php namespace App\Http\Models\Common;
use Illuminate\Database\Eloquent\Model;


/**
 * BaseModel:
 * @date 14-4-3
 * @time 下午3:01
 * @author Ray.Zhang <zgh@lansee.net>
 **/
abstract class BaseModel extends Model {

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