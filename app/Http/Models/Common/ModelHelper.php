<?php namespace App\Http\Models\Common;

use Paginator;
/**
 * BaseModel:
 * @date 14-3-31
 * @time 上午10:03
 * @author Ray.Zhang <zgh@lansee.net>
 **/
/**
 * Class ModelHelper
 * @package Api\Models\Common
 * @deprecated use BaseModel instead
 */
class ModelHelper {

    static function _error($message, $code = 12000)
    {
        return ['__code' => $code, '__message' => $message];
    }

    static function _success($message, $data = [])
    {
        return static::_result('ok', $message, $data);
    }

    static function _fail($message)
    {
        return static::_result('error', $message);
    }

    static function _result($status, $message = '', $data = [])
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
	
	/**
	 *
	 *Collection convert to Paginator 主要用于获取所有列表项，并兼容分页
	 *@param  Collection $obj
	 *@return Paginator
	 */
	static function c2p($collection)
    {
       if( is_array($collection) or ( $collection instanceof Illuminate\Database\Eloquent\Collection ))
	   {
			return Paginator::make($collection, 0, count($collection));
	   }
	   else
	   {
			return $collection;
	   }
    }
	
	/**
	 *将array 初始化为一个Paginator对象
	 *@param  array $array 
	 *@return Paginator|mixed
	 */
	static function a2p($array)
	{
	   $item    = isset($array['data'])     ? $array['data']     : [];
	   $perPage = isset($array['per_page']) ? $array['per_page'] : 10;
	   $total   = isset($array['total'])    ? $array['total']    : $perPage;
	   if(is_array($array))
	   {
			return Paginator::make($item, $total, $perPage);
	   }
	   else
	   {
			return $array;
	   }
	}
}