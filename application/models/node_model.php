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

    public $is_cache = FALSE;

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

    public function getNodeTree($where = array(), $isMenu = false)
    {
        $isMenu && $where[] = array('isMenu'=>1);
        $list = $this->get_list($where);
        $nodes = $list['rows'];
        $moduleTree = array();
        foreach($nodes as $node) {
            $moduleTree[$node['module']][] = $node;
        }
        return $moduleTree;
    }

    /**
     * 获取模块
     * @return mixed
     */
	public function getModules(){
		$query = $this->db->distinct()->select('module')->get($this->table);
		$modules = $query->result_array();
		return $modules;
	}

}