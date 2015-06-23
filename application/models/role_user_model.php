<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Role_User_Model extends Base_Model
{

    public $table = 'role_user';

    public $is_cache = FALSE;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $roleUsers
     *
     * @return bool
     */
    public function batch_insert($roleUsers = array())
    {
        //$this->query('start transaction');
        foreach ($roleUsers as $roleUser) {
            $result = $this->insert($roleUser);
            if (!$result) {
                //$this->query('rollback');
                return false;
            }
        }
        return true;
        //return $this->query('commit');
    }

}