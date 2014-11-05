<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-24
 * Time: 上午10:46
 */
class Link_Model extends Base_model
{

  /**
   * 文章表名字
   * @var string
   */
  public $link_table = 'link';

  /**
   * 文章分类表名字
   * @var string
   */
  public $link_sort_table = 'link_sort';

  /**
   * 表创建语句
   * @var string
   */
  public $model_install_sql = <<<EOF
CREATE TABLE `boren_link` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `sort_id` int(3) NOT NULL DEFAULT '1',
  `link_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `link_pic` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '????',
  `add_time` int(10) NOT NULL,
  `click_number` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `boren_link_sort` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `alias` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
   * 文章添加
   * @param $data
   * @return mixed
   */
  public function add_link($data)
  {
    $data = (array)$data;
    $result = $this->db->insert($this->link_table, $data);
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
   * 文章删除
   * @param $where
   * @return mixed
   */
  public function delete_link($where)
  {
    $this->db->from($this->link_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 编辑文章
   * @param $where
   * @param $data
   * @param null $table
   */
  public function update_link($where, $data, $table = NULL)
  {
    is_null($table) && $table = $this->link_table;
    $this->update($where, $data, $table);
  }

  /**
   * 根据获取文章
   * @param $id
   * @return mixed
   */
  public function get_link($id)
  {
    $this->table = $this->link_table;
    return $this->get_row_array(array('id'=>$id));
  }

  /**
   * 获取链接分页列表
   * @param string $extend
   * @param int $limit
   * @return mixed
   */
  public function get_link_page_list($extend = '', $limit = 18)
  {
    $this->db->start_cache();
    $this->db->from($this->link_table);
    $this->db->join($this->link_sort_table, $this->link_sort_table.'.id='.$this->link_table.'.sort_id', 'left');
    $extend && $this->db->where($extend, null, false);
    $count = $this->db->count_all_results();

    $this->load->library('HyPage');
    $this->hypage->init($count, $limit);
    $this->db->select($this->link_sort_table.'.sort_name');
    $this->db->select($this->link_table.'.*');
    $this->db->limit($this->hypage->ListRow);
    $this->db->offset($this->hypage->FirstRow);
    $list = $this->db->get()->result_array();
    $this->db->stop_cache();
    $this->db->flush_cache();

    $data['list'] = $list;
    $data['page'] = $this->hypage->show($this->config->config['base_url'].'/admin/link');
    $data['count'] = $count;
    return $data;
  }

  /**
   * 获取链接列表
   * @param $extend
   * @param int $limit
   * @param string $order_by
   * @return mixed
   */
  public function get_link_list($extend, $limit=10, $order_by='link.id desc')
  {
    $this->db->select($this->link_sort_table.'.sort_name');
    $this->db->select($this->link_table.'.*');
    $this->db->from($this->link_table);
    $this->db->join($this->link_sort_table, $this->link_sort_table.'.id='.$this->link_table.'.sort_id', 'left');
    if (is_array($extend))
    {
      $extend && $this->db->where($extend);
    }
    elseif (is_string($extend))
    {
      $extend && $this->db->where($extend, null, false);
    }
    $this->db->order_by($order_by);
    $this->db->limit($limit);
    $data = $this->db->get()->result_array();
    return $data;
  }

  /**
   * 分类添加
   * @param $data
   * @return bool
   */
  public function add_sort($data)
  {
    $result = $this->db->insert($this->link_sort_table, $data);
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
   * 分类删除
   * @param $where
   * @return mixed
   */
  public function delete_sort($where)
  {
    $this->db->from($this->link_sort_table);
    $this->db->where($where);
    return $this->db->delete();
  }

  /**
   * 保存分类
   * @param $where
   * @param $data
   */
  public function update_sort($where, $data)
  {
    $table = $this->link_sort_table;
    $this->update($where, $data, $table);
  }

  /**
   * 获取文章分类
   * @param $id
   * @return mixed
   */
  public function get_sort($id)
  {
    $this->table = $this->link_sort_table;
    return $this->get_row_array(array('id'=>$id));
  }

  /**
   * 获取分类id
   * @param $id
   * @param bool $is_kids
   * @return string
   */
  public function get_sort_id($id, $is_kids = false)
  {
    $this->db->from($this->link_sort_table);
    $this->db->where('parent_id in('.$id.')', null, false);
    $data = $this->db->get()->result_array();
    $string = '';
    foreach ($data as $value) {
      $string = $string .','. $value['id'];
      $string = $string . $this->get_sort_id($value['id'], true);
    }
    if ($is_kids) {
      return $string;
    } else {
      return $id . $string;
    }
  }

  /**
   * 获取分类树
   * @param int $parent_id
   * @param $max_grade
   * @param string $extend
   * @param string $order
   * @param string $limit
   * @param int $grade
   * @return array
   */
  public function get_sort_tree($parent_id = 0, $max_grade = -1, $extend = '', $order = '`sequence` asc, `id` asc', $limit='', $grade = 1)
  {
    if ($max_grade === -1 || $grade <= $max_grade) {
      $this->table = $this->link_sort_table;
      $this->db->from($this->link_sort_table);
      $this->db->order_by($order);
      $where = array();
      $where[] = 'parent_id='.$parent_id;
      $extend && $where[] = $extend;
      $where = join(' AND ', $where);
      $sort_list = $this->db->where($where, null, false)->get()->result_array();

      foreach($sort_list as $k => $parent)
      {
        $kids = $this->get_sort_tree(intval($parent['id']), $max_grade, $extend, $order, $limit, $grade+1);
        count($kids) && $sort_list[$k]['kids'] = $kids;
      }
      return $sort_list;
    }
  }

  public function set_sort_tree($list, $grade=1)
  {
    $tab = '&nbsp;&nbsp;&nbsp;&nbsp;';
    $sign = '|--&nbsp;';
    $string = '';
    for ($i = 1; $i < $grade; $i++) {
      $string .= $tab;
    }
    foreach ($list as $key => &$value) {
      $value['sort_name'] = $string . $sign . $value['sort_name'];
      $data[] = $value;
      //获取子菜单
      if (isset($value['kids'])) {
        $data = array_merge($data, (array)$this->set_sort_tree($value['kids'], $grade+1));
      }
    }
    return $data;
  }
}