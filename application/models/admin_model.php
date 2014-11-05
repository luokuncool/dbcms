<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Admin_Model extends Base_model {

  public $admin_table = 'admin';
  public $admin_group_table = 'admin_group';

  //模块数据表创建语句
  public $model_install_sql = <<<EOF
CREATE TABLE `ci_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `purview_key` text COLLATE utf8_unicode_ci,
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ci_admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `group_id` int(3) NOT NULL DEFAULT '-1' COMMENT '分组id',
  `reg_time` int(10) NOT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `login_times` int(4) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_sid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_time` int(10) DEFAULT NULL,
  `active_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  }

  /**
   * 添加管理组
   * @param $data
   * @return bool
   */
  public function add_admin_group($data)
  {
    $data = (array)$data;
    $result = $this->db->insert($this->admin_group_table, $data);
    if ($result)
    {
      return $this->db->insert_id();
    }
    else
    {
      return FALSE;
    }
  }

  /**
   * 管理组删除
   * @param $where
   * @return mixed
   */
  public function delete_admin_group($where)
  {
    $this->db->from($this->admin_group_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 更新分组
   * @param $where
   * @param $data
   */
  public function update_admin_group($where, $data)
  {
    $this->update($where, $data, $this->admin_group_table);
  }

  /**
   * 获取分组列表
   * @param $where
   * @return mixed
   */
  public function get_admin_group_list($where = '')
  {
    $this->db->from($this->admin_group_table);
    $where && $this->db->where($where, null, false);
    $data = $this->db->get()->result_array();
    return $data;
  }

  /**
   * 获取管理组
   * @param $id
   * @return mixed
   */
  public function get_group($id)
  {
    $this->db->from($this->admin_group_table);
    $this->db->where(array('id'=>intval($id)));
    $data = $this->db->get()->row_array();
    return $data;
  }

  /**
   * 添加管理员
   * @param $data
   * @return bool
   */
  public function add_admin($data)
  {
    $data = (array)$data;
    $result = $this->db->insert($this->admin_table, $data);
    if ($result)
    {
      return $this->db->insert_id();
    }
    else
    {
      return FALSE;
    }
  }

  /**
   * 删除管理员
   * @param $where
   * @return mixed
   */
  public function delete_admin($where)
  {
    $this->db->from($this->admin_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 更新管理员
   * @param $where
   * @param $data
   */
  public function update_admin($where, $data)
  {
    $this->update($where, $data, $this->admin_table);
  }

  /**
   * 获取管理员
   * @param $id
   * @return array
   */
  public function get_admin($id)
  {
    $this->db->from($this->admin_table.' AS admin');
    $this->db->select('admin.*, admin_group.group_name, admin_group.purview_key');
    $this->db->join($this->admin_group_table.' AS admin_group', 'admin_group.id=admin.group_id', 'left');
    $this->db->where('admin.id', $id);
    return $this->db->get()->row_array();
  }

  /**
   * 获取管理员列表
   * @param $where
   * @return mixed
   */
  public function get_admin_list($where)
  {
    $this->db->from($this->admin_table.' AS admin');
    $this->db->join($this->admin_group_table.' AS admin_group', 'admin.group_id=admin_group.id', 'left');
    $this->db->select('admin.*, admin_group.group_name');
    $where && $this->db->where($where, null, false);
    $data = $this->db->get()->result_array();
    return $data;
  }

}