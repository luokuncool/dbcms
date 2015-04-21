<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Node_Model extends Base_Model
{

    public $table = 'node';

    public $is_cache = TRUE;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 检测节点代码唯一
     *
     * @param  $code
     *
     * @return bool
     */
    public function check_code($code)
    {
        $where = array();
        $where['code'] = $code;
        return $this->exists($where);
    }

    /**
     * 检测节点名字唯一
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