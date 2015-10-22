<?php namespace App\Http\Models\User;
use App\Http\Models\Common\BaseModel;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-9
 * Time: 下午9:24
 */
class UserModel extends BaseModel
{
    public function regiset($data)
    {
        return D('user')->insert($data);
    }
}