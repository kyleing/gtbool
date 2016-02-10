<?php namespace App\Http\Controllers\Team;
use App\Http\Controllers\BaseController;
use App\Http\Models\Team\TeamModel;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: tguo
 * Date: 16/2/4
 * Time: 下午9:26
 */

class TeamController extends BaseController
{
    public function getIndex()
    {
        return view('homepage.team.index');
    }

    public function getDetail()
    {
        return view('homepage.team.detail');
    }

    public function getInfo()
    {
        $name = Input::get('name','');
        $allTime = (new TeamModel())->getAllTime();
        return $allTime;
    }
}