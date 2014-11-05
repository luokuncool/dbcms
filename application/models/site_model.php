<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 下午3:44
 */

class Site_Model extends CI_Model {

  public $site_table = 'site';

  public $model_install_sql = <<<EOF
CREATE TABLE `ci_site` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `site_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellphone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icp` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `third_code` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
EOF;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * 获取站点信息
   * @return mixed
   */
  public function get_site_info()
  {
    $site_info = $this->db->get_where($this->site_table, array('id'=>1))->row_array();
    return $site_info;
  }

}