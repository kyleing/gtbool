<?php namespace App\Http\Models\Common;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


/**
 * DBOperator:
 * @date 14-3-24
 * @time 下午3:44
 * @author Ray.Zhang <zgh@lansee.net>
 **/
class DBOperator {

    static $TABLE_PKEY = [];

    /**
     * @var string 操作表名
     */
    private $table;
    /**
     * @var \Illuminate\Database\Query\Builder
     */
    private $operator;

    /**
     * @var string 主键名
     */
    private $pkey = 'id';

    /**
     * meta表的对象id键名
     * @var string
     */
    private $mkey = 'iid';

    private $meta_sets = array();

    /**
     * @var int default is 10
     */
    private $pageSize = 10;

    /**
     * @var int start with 1
     */
    private $pageNo = 0;

    private $_fields = [];

    /**
     * @param $table
     * @param $primaryKey
     * @param string $meta_key
     * @param array $fields
     */
    function __construct($table, $primaryKey, $meta_key = 'iid', $fields = [])
    {
        $this->table = $table;
        $this->operator = DB::table($table);
        $this->pkey = $primaryKey;
    }

    /**
     * 构建一个DBOperator对象
     * @param string $table
     * @param string $key
     * @param string $meta_key default is 'iid'
     * @return DBOperator
     */
    static function table($table, $key = '', $meta_key = 'iid')
    {
        if (empty($key))
        {
            $key = isset(self::$TABLE_PKEY[$table]) ? self::$TABLE_PKEY[$table] : 'id';
        }

        $fields = \Cache::remember('db.cache.' . $table . '.fields', 1, function () use ($table)
        {
            return (new DBOperator($table, 'id'))->fields();
        });

        return new DBOperator($table, $key, $meta_key, $fields);
    }

    /**
     * @param array $fields
     * @return array
     */
    public function fields($fields = [])
    {
        if (empty($fields))
        {
            $conn = $this->operator->getConnection();
            if ($conn->getName() == 'mysql')
            {
                $results = $conn->select((new \Illuminate\Database\Schema\Grammars\MySqlGrammar())->compileColumnExists(), [$conn->getDatabaseName(), $conn->getTablePrefix() . $this->table]);
                $this->_fields = array_map(function ($v)
                {
                    return is_array($v) ? $v['column_name'] : $v->column_name;
                }, $results);
            }
        }
        return $this->_fields;
    }


    
    /**
     * 设置主键
     * @param string $keyName 主键名
     * @return $this
     */
    public function primaryKey($keyName)
    {
        $this->pkey = $keyName;
        return $this;
    }

    /**
     * 设置meta键
     * @param $keyName
     * @return $this
     */
    public function metaKey($keyName)
    {
        $this->mkey = $keyName;
        return $this;
    }

    /**
     * 获得内部的Query建造类
     * @return \Illuminate\Database\Query\Builder
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * 重置内部operator
     */
    public function reset()
    {
        $this->operator = DB::table($this->table);
        return $this;
    }

    /**
     *  查询方法: findBy, findByOne, findById
     */

    /**
     * 按条件查询，条件规则位 [$field1 => $value, $field2 => [$operator, $value]]
     * @param array $conds
     * @param array $fields 要查询的字段
     * @param int $max 查询记录数, 0为不限制
     * @return mixed 结果记录
     */
    public function findBy(array $conds, $fields = [], $max = 0)
    {
        $this->_wheres($conds);
        if ($max)
        {
            $this->limit($max);
        }
        $my_fields = $this->fields();
        $fields = empty($fields) ? array_diff($my_fields, ['deleted_at']) : $fields;
        foreach ($fields as &$field)
        {
            $field = str_contains($field, '.') ? $field : $this->table . '.' . $field;
        }
        $this->select(empty($fields) ? [$this->table . '.*'] : $fields);
        return $this->get();
    }

    /**
     * 根据主键获得记录，成功以array返回记录，失败返回null
     * @param int $id
     * @param array $fields
     * @return null|array
     */
    public function findById($id, $fields = [])
    {
        return $this->findByOne([$this->pkey => $id], $fields);
    }

    /**
     * 查询一条记录
     * @param array $conds
     * @param array $fields
     * @return null|array
     */
    public function findByOne(array $conds, $fields = [])
    {
        $arr = $this->findBy($conds, $fields, 1);
        return empty($arr) ? null : $arr[0];
    }

    /**
     * 判断是否存在符合条件的记录
     * @param array $conds
     * @return bool
     */
    public function exist(array $conds)
    {
        $a = $this->findByOne($conds, [$this->table . '.' . $this->pkey]);
        return !empty($a);
    }

    /**
     * 插入更新操作 upsertBy, upsertById, updateBy, updateById
     */

    /**
     * 更新记录，若不存在则插入新记录
     * @param array $obj 条件只能包含等于的判断，不支持比较操作符号
     * @param array $cri 作为约束的字段, 如: ['order_id', 'created_at']
     * @param bool $insert 如果不存在是否创建新对象
     * @return array|bool 成功返回$obj，失败返回false
     */
    public function upsertBy(array $obj, array $cri, $insert = true)
    {
        $conds = array_only($obj, $cri);
        $old = $this->findByOne($conds, [$this->pkey]);
        if ($old)
        { //exist, so just update
            $obj[$this->pkey] = $old[$this->pkey];
            $obj = $this->updateById($obj);
        }
        else
        {
            if ($insert)
            {
                return $this->insert($obj);
            }
        }
        return $obj;
    }

    /**
     * 根据主键id更新
     * @param array $obj array('id'=>123, ...)
     * @param bool $insert
     * @return array|bool
     */
    public function upsertById(array $obj, $insert = true)
    {
        if (!(isset($obj[$this->pkey])))
        {
            //obj haven't primary key
            return false;
        }
        return $this->upsertBy($obj, [$this->pkey], $insert);
    }

    /**
     * @param $table
     * @param $key $table.key
     * @param bool $fkey $this->table.key
     * @return $this
     */
    public function leftJoinOn($table, $key, $fkey = false)
    {
        $fkey = $fkey ?: $key;
        $key = starts_with($key, $table . '.') ? $key : $table . '.' . $key;
        $fkey = starts_with($key, $this->table . '.') ? $fkey : $this->table . '.' . $fkey;
        $this->operator = $this->operator->leftJoin($table, $key, '=', $fkey);
        return $this;
    }

    /**
     * @param string $table table name
     * @param string $key $table.key
     * @param string|bool $fkey $this->table.key
     * @return $this
     */
    public function innerJoinOn($table, $key, $fkey = false)
    {
        $fkey = $fkey ?: $key;
        $key = starts_with($key, $table . '.') ? $key : $table . '.' . $key;
        $fkey = starts_with($key, $this->table . '.') ? $fkey : $this->table . '.' . $fkey;
        $this->operator = $this->operator->join($table, $key, '=', $fkey);
        return $this;
    }

    /**
     * 插入记录
     * @param array $obj
     * @return bool|array 成功返回带id的对象，否则返回false
     */
    function insert($obj)
    {
        $retId = $this->operator->insertGetId($obj);
        if ($retId)
        {
            $obj[$this->pkey] = $retId;
        }
        return $obj;
    }

    function delete($id){
        $retId = $this->operator->delete($id);
        if ($retId)
        {//todo if here a bug ?
            $obj[$this->pkey] = $retId;
        }
        return $id;
    }

    /**
     * @desc 取得某个列的记录
     * @param array $conds
     * @param string $field
     * @return  array
     */

    public function findByField($conds, $field)
    {
        return array_column($this->findBy($conds, [$field]), $field);

    }

    /**
     * 按约束添加记录，存在则根据约束返回，否则则插入一条记录返回
     * @param array $obj 数据
     * @param array $cri 唯一字段,为空则与insert相同
     * @return array|bool
     */
    function add($obj, $cri = [])
    {
        $old = empty($cri) ? false : $this->findByOne(array_only($obj, $cri));
        return $old ?: $this->insert($obj);
    }

    /**
     * 更新记录，参数解释见upsert方法
     * @param array $obj array('f1'=>'v1','f2'=>'v2','f3'=>'v3',...)
     * @param array $cri array('f1','f2','f3',...)
     * @return array|bool 成功返回$obj，失败返回false
     */
    public function updateBy($obj, $cri)
    {
        if (empty($cri))
        {
            return $obj;
        }
        $conds = array_only($obj, $cri);
        if (count($conds) == count($cri))
        {
            $sets = array_except($obj, $cri);
            $this->_wheres($conds)->update($sets);
            return $obj;
        }
        else
        {
            return $obj;
        }

    }

    /**
     * 根据主键id更新
     * @param array $obj array('id'=>'123', 'f1'=>'v1', 'f2'=>'v2')
     * @return array|bool
     */
    public function updateById($obj)
    {
        return $this->updateBy($obj, [$this->pkey]);
    }

    /**
     * 查询结果集数目
     * @param array $conds 查询条件
     * @return mixed
     */
    public function rows($conds)
    {
        return $this->_wheres($conds)->select('count(' . $this->table . '.' . $this->pkey . ')')->count();
    }

    /**
     * 查询总和
     * @param $conds
     * @param $field
     * @return int
     */
    public function sum($conds, $field)
    {
        return $this->_wheres($conds)->operator->sum($field) ?: 0;
    }

    public function meta_operator()
    {
        return D($this->table . '_meta');
    }

    /**
     * 活动对应得meta值，例如order，则会从表order_meta中读取或者设置meta值
     * @param string $iid
     * @param bool|string $key
     * @param mixed $val
     * @return mixed
     */
    public function meta($iid, $key, $val = null)
    {
        $iid = is_array($iid) ? $iid[$this->pkey] : $iid;
        $meta_op = D($this->table . '_meta');
        $obj = [$this->mkey => $iid];
        if (!$key)
        {
            return $this->metadata($iid, $val);
        }
        else
        {
            $obj = array_add($obj, 'key', $key);
        }

        if ($val === null)
        {
            $one = $meta_op->findByOne($obj, ['value']);
        }
        else
        {
            $val = json_encode($val);
            $one = $meta_op->upsertBy(array_add($obj, 'value', $val), ['iid', 'key']);
        }

        return $one ? json_decode($one['value'], true) : false;
    }

    /**
     * Get/update all the meta data of the object
     * @param int|string $iid object id
     * @param bool|array $data
     * @return array
     */
    public function metadata($iid, $data = false)
    {
        $meta_op = D($this->table . '_meta');
        if (!empty($data))
        {
            $data = empty($this->meta_sets) ? $data : array_only($data, $this->meta_sets);
            foreach ($data as $k => $v)
            {
                $this->meta($iid, $k, $v);
            }
        }
        $data = $meta_op->findBy(['iid' => $iid]);
        $meta = [];
        foreach ($data as $kv)
        {
            $kv['value'] = json_decode($kv['value'], true);
            if (isset($meta[$kv['key']]))
            {
                $meta[$kv['key']] = (array)$meta[$meta[$kv['key']]];
                array_push($meta[$kv['key']], $kv['value']);
            }
            else
            {
                $meta[$kv['key']] = $kv['value'];
            }
        }
        return $meta;
    }

    /**
     * 设置分页查询
     * @param int $pnum 页号
     * @param int $psize 页大小
     * @return $this
     */
    public function page($pnum = 1, $psize = 10)
    {
        $this->pageNo = $pnum;
        $this->pageSize = $psize;
        return $this->offset(($pnum - 1) * $psize)->limit($this->pageSize);
    }

    /**
     * 写入判断条件
     * @param array $conds 选择条件 array('f1'=>['op1','v1'], 'f2'=>'v2')
     * @return $this
     */
    public function wheres($conds)
    {
//        $this->operator = \DB::table($this->table);
        return $this->_wheres($conds);
    }

    /**
     * @param array $orders
     * @param string $v 兼容原来的方法
     * @return $this
     */
    public function orderBy($orders = [], $v = 'desc')
    {
        if (empty($orders))
        {
            return $this;
        }

        if (is_array($orders))
        {
            foreach ($orders as $k => $v)
            {
                $this->operator->orderBy($k, $v);
            }
        }
        else
        {
            $this->operator->orderBy($orders, $v);
        }
        return $this;
    }

    /**
     * like wheres function ,call by internal
     * @param array $conds
     * @return $this
     */
    protected function _wheres($conds)
    {
        foreach ($conds as $field => $opAndVal)
        {
            if (is_null($opAndVal))
            {
                $opAndVal = [null];
            }
            $opAndVal = (array)$opAndVal;
            $op = strtolower(count($opAndVal) == 1 ? '=' : $opAndVal[0]);
            $val = last($opAndVal);
            $field = str_contains($field, '.') ? $field : $this->table . '.' . $field;
            switch ($op)
            {
                case 'in':
                {
                    if (count($val) == 1)
                    {
                        $this->operator->where($field, '=', $val[0]);
                    }
                    else
                    {
                        $this->operator->whereIn($field, $val);
                    }
                    break;
                }
                case 'between':
                {
                    $this->operator->whereBetween($field, $val);
                    break;
                }
                case 'raw':
                {
                    $this->operator->whereRaw($val);
                    break;
                }
                default:
                    $this->operator->where($field, $op, $val);

            }

        }
        return $this;
    }

    /**
     * 代理$this->operator的所有方法
     * @param string $method
     * @param array $parameters
     * @return $this|mixed
     */
    public function __call($method, $parameters)
    {
        $res = call_user_func_array(array($this->operator, $method), $parameters);
        $this->operator = ($res instanceof Builder) ? $res : $this->operator;
        if ($res instanceof Builder)
        {
            $this->operator = $res;
            return $this;
        }
        else
        {
            return $res;
        }
    }
}
