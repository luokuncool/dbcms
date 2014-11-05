<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午2:54
 */
class Admin_Router_Model extends Base_model
{

  public $admin_router_table = 'admin_router';

  public $model_install_sql = <<<EOF
CREATE TABLE `ci_admin_router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `side_menu` tinyint(1) NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `menu_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `purview_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '其它',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOF;


  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->table = $this->admin_router_table;
    $this->get_group_router_list();
  }

  /**
   * 添加
   * @param $data
   * @return bool
   */
  public function add_router($data)
  {
    $result = $this->db->insert($this->admin_router_table, $data);
    if ($result)
    {
      return $this->db->insert_id();
    }
    else
    {
      return FALSE;
    }
  }

  public function get_router($where)
  {
    $this->db->from($this->admin_router_table);
    $this->db->where($where);
    return $this->db->get()->row_array();
  }

  /**
   * @param string $where
   * @return mixed
   */
  public function get_group_list($where = '')
  {
    $where && $this->db->where($where);
    $this->db->from($this->admin_router_table)->group_by('group_name')->order_by('id asc');
    $this->db->select('group_name');
    $list = $this->db->get()->result_array();
    return $list;
  }

  /**
   * 获取路由分组列表
   * @param bool $menu
   * @return mixed
   */
  public function get_group_router_list($menu = TRUE)
  {
    $group_list = $this->get_group_list();
    foreach($group_list as $k => $group)
    {
      $menu && $where['side_menu'] = '1';
      $where['group_name'] = $group['group_name'];
      $router_list = $this->get_where($where)->result_array();
      $group_list[$k]['router_list'] = $router_list;
    }
    return$group_list;
  }

  /**
   * 获取权限分组列表
   * @return mixed
   */
  public function get_purview_group_list()
  {
    $group_list = $this->get_group_list();
    foreach($group_list as $k => $group)
    {
      $where['group_name'] = $group['group_name'];
      $this->db->from($this->admin_router_table);
      $this->db->order_by('sequence asc');
      $this->db->where($where);
      $router_list = $this->db->get()->result_array();
      $group_list[$k]['router_list'] = $router_list;
    }
    return$group_list;
  }

  /**
   * 获取菜单分组
   * @param string $where
   * @return mixed
   */
  public function get_menu_group_list($where = '')
  {
    $group_list = $this->get_group_list($where);
    foreach($group_list as $k => $group)
    {
      $kids_where['side_menu'] = '1';
      $kids_where['group_name'] = $group['group_name'];
      $this->db->from($this->admin_router_table);
      $this->db->order_by('sequence asc');
      $this->db->where($kids_where);
      $where && $this->db->where($where);
      $router_list = $this->db->get()->result_array();
      if ($router_list)
      {
        $group_list[$k]['router_list'] = $router_list;
      }
      else
      {
        unset($group_list[$k]);
      }
    }
    return$group_list;
  }
}