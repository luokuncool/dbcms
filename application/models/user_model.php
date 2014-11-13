<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class User_Model extends Base_Model {

	public $table = 'user';

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
	 * 登陆
	 * @param $uName
	 * @param $password
	 *
	 * @return mixed 1、用户名不存在；2、密码错误；3、账户被禁用; 否则成功
	 */
	public function login($uName, $password)
	{
		$map['uName'] = $uName;
		$user = $this->get_row_array($map);
		if (!$user) return 1;
		if (md5($password) != $user['password']) return 2;
		if ($user['status'] == 0) return 3;
		unset($user['password']);
		$this->update($map, array('lastLoginTime'=>time()));
		return $user;
	}

}