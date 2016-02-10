<?php namespace App\Http\Controllers\Blog\User;

use App\Http\Controllers\BaseController;
use App\Http\Models\Blog\User\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

/**
 * Created by PhpStorm.
 * User: gt
 * Date: 15-10-9
 * Time: 下午8:43
 */
class UserController extends BaseController
{
    public function getLogin()
    {
        return view('homepage.signin');
    }
    public function postRegister()
    {
        $data = Input::all();
        if($data['user_name'] == '')
        {
            return Redirect::back()
                ->with(['msg' => '请填写用户名']);
        }
        if($data['password'] == '')
        {
            return Redirect::back()
                ->with(['msg' => '请填写密码']);
        }

        $data['password'] = Hash::make($data['password']);
        $user = new UserModel();
        return $user->regiset($data);
    }

    public function postLogin()
    {
        $data = Input::all();

        if(Auth::attempt($data))
        {
            return Auth::user();
        }
        else
        {
            return 'no';
        }
    }
}