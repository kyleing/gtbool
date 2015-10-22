<?php namespace App\Http\Models\Common;

/**
 * CURDModel: 
 * @date 15/5/25
 * @time 00:43
 * @author Ray.Zhang <codelint@foxmail.com>
 **/
interface CURDInterface{
    /**
     * page search
     * @param $data
     * @return mixed
     */
    function search($data);
    function create($data);
    function add($data);
    function update($data);
    function upsert($data);
    function remove($data);
}