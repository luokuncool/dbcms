<?php

/**
 * 系统配置参数管理model
 */
class Config_model extends Base_Model
{

    public $table = 'config';

    public $is_cache = FALSE;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

}