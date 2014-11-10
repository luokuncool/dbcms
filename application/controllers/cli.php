<?php
/**
 * 命令行运行工具
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午3:40
 */

class Cli extends Home_Controller
{

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 更新缓存
	 */
	public function update_cache()
	{
		$this->load->driver('cache', $this->config->config['cache_type']);
		$changedRows = $this->cache->get($this->config->config['changed_row']);
		foreach($changedRows as $table=>$rows) {
			// todo 完善缓存更新
			while($ids = $this->cache->get($table)) {
				foreach($ids as $key=>$id) {
					$cacheKey = $table.$id['id'];
					$row = $this->db->from($table)->where($id)->get()->row_array();
					$this->cache->delete($cacheKey);
					$row && $result = $this->cache->save($cacheKey, $row, 0);
					if (!$row OR $result) {
						unset($ids[$key]);
					}
					//file_put_contents('test', date('Y-m-d H:i:s'), "\n");
				}
				$this->cache->delete($table);
				$this->cache->save($table, $ids, 0);
			}
		}
	}

}