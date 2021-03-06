<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Test_Model extends Base_Model
{

    public $table = 'test';

    public $is_cache = TRUE;

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
        $this->query('start transaction');
        foreach ($roleUsers as $roleUser) {
            $result = $this->insert($roleUser);
            if (!$result) {
                $this->query('rollback');
                return false;
            }
        }
        return $this->query('commit');
    }

}