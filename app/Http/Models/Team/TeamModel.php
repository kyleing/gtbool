<?php namespace App\Http\Models\Team;
use App\Http\Models\Common\BaseModel;
use App\Http\Models\Common\SchemaTrait;
/**
 * Created by PhpStorm.
 * User: tguo
 * Date: 16/2/6
 * Time: 下午1:24
 */

class TeamModel extends BaseModel
{
    use SchemaTrait;

    public function getAllTime()
    {
        $allEnd = D($this->tb_team)->sum([],'end');
        $allStart = D($this->tb_team)->sum([],'start');
        $allTime = $allEnd - $allStart;
        return $allTime;
    }
}