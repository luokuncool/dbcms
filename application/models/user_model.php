<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class User_Model extends Base_model {

  public $user_table = 'user';

  //模块数据表创建语句
  public $model_install_sql = <<<EOF
CREATE TABLE `boren_user` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
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
   * 添加管理员
   * @param $data
   * @return bool
   */
  public function add_user($data)
  {
    $data = (array)$data;
    $result = $this->db->insert($this->user_table, $data);
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
  public function delete_user($where)
  {
    $this->db->from($this->user_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 更新管理员
   * @param $where
   * @param $data
   */
  public function update_user($where, $data)
  {
    $this->update($where, $data, $this->user_table);
  }

  /**
   * 获取管理员
   * @param $id
   * @return array
   */
  public function get_user($id)
  {
    $this->db->from($this->user_table.' AS user');
    $this->db->select('user.*');
    //$this->db->join($this->user_group_table.' AS user_group', 'user_group.id=user.group_id', 'left');
    $this->db->where('user.id', $id);
    return $this->db->get()->row_array();
  }

  /**
   * 获取管理员列表
   * @param $where
   * @return mixed
   */
  public function get_user_list($where)
  {
    $this->db->from($this->user_table.' AS user');
    //$this->db->join($this->user_group_table.' AS user_group', 'user.group_id=user_group.id', 'left');
    $this->db->select('user.*');
    $where && $this->db->where($where, null, false);
    $data = $this->db->get()->result_array();
    return $data;
  }

}