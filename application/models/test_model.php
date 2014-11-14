<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Test_Model extends Base_Model {

	public $table = 'test';

	public $is_cache = TRUE;

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		$config = array(

		);
		$config['hostname'] = 'localhost';
		$config['username'] = 'root';
		$config['password'] = 'root';
		$config['database'] = 'test';
		$config['dbdriver'] = 'mysql';
		$config['dbprefix'] = 'adm_';
		$config['pconnect'] = TRUE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$config['swap_pre'] = '';
		$config['autoinit'] = TRUE;
		$config['stricton'] = FALSE;
		$this->load->database($config);
	}

	/**
	 * @param array $roleUsers
	 * @return bool
	 */
	public function batch_insert($roleUsers = array()) {
		$this->query('start transaction');
		foreach($roleUsers as $roleUser) {
			$result = $this->insert($roleUser);
			if (!$result) {
				$this->query('rollback');
				return false;
			}
		}
		return $this->query('commit');
	}

}