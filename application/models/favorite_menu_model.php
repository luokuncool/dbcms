<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-25
 * Time: 上午10:28
 */
class Favorite_Menu_Model extends Base_Model {

    public $table = 'favorite_menu';

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
     * 批量插入
     * @param array $favoriteMenus
     * @return bool|mixed
     */
    public function batch_insert($favoriteMenus = array()) {
        //$this->query('start transaction');
        foreach($favoriteMenus as $menu) {
            $result = $this->insert($menu);
            if (!$result) {
                //$this->query('rollback');
                //return false;
            }
        }
        return true;
        //return $this->query('commit');
    }

}