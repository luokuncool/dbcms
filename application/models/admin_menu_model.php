<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Admin_Menu_Model extends Base_model {

  public $admin_menu_table = 'admin_menu';

  //模块数据表创建语句
  public $model_install_sql = <<<EOF
CREATE TABLE `boren_admin_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) NOT NULL,
  `menu_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sequence` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `router_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FOREIGN` (`admin_id`),
  CONSTRAINT `ForeignKey` FOREIGN KEY (`admin_id`) REFERENCES `boren_admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
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
   * 添加菜单
   * @param $data
   * @return bool
   */
  public function add_admin_menu($data)
  {
    $data = (array)$data;
    $result = $this->db->insert($this->admin_menu_table, $data);
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
  public function delete_admin_menu($where)
  {
    $this->db->from($this->admin_menu_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 更新分组
   * @param $where
   * @param $data
   */
  public function update_admin_menu($where, $data)
  {
    $this->update($where, $data, $this->admin_menu_table);
  }

  /**
   * 获取分组列表
   * @param $where
   * @return mixed
   */
  public function get_admin_menu_list($where = '')
  {
    $this->db->from($this->admin_menu_table);
    $this->db->order_by('sequence asc');
    $where && $this->db->where($where, null, false);
    $data = $this->db->get()->result_array();
    return $data;
  }

  /**
   * 获取管理组
   * @param $id
   * @return mixed
   */
  public function get_menu($id)
  {
    $this->db->from($this->admin_menu_table);
    $this->db->where(array('id'=>intval($id)));
    $data = $this->db->get()->row_array();
    return $data;
  }

}