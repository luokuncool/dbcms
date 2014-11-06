<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class User_Model extends Base_Model {

  public $table = 'users';

  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

}