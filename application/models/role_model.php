<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Role_Model extends Base_Model
{

    public $table = 'role';

    public $is_cache = TRUE;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检测名字唯一
     *
     * @param      $name
     *
     * @return bool
     */
    public function check_name($name)
    {
        $where = array();
        $where['name'] = $name;
        return $this->exists($where);
    }

}