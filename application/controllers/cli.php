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
		$this->load->driver('cache', config_item('cache_type'));
		$changedRows = $this->cache->get(config_item('changedRow'));
		foreach($changedRows as $table=>$ids) {
			foreach($ids as $key=>$id) {
				$cacheKey = $table.$id;
				$row = $this->db->from($table)->where('id', $id)->get()->row_array();
				$this->cache->delete($cacheKey);
				$row && $result = $this->cache->save($cacheKey, $row, config_item('dataCacheTime'));
				if (!$row OR $result) {
					unset($ids[$key]);
				}
			}
			$changedRows[$table] = $ids;
		}
		$this->cache->delete(config_item('changedRow'));
		$this->cache->save(config_item('changedRow'), $changedRows, config_item('dataCacheTime'));
		echo_json(
			array(
				'success' => 1,
				'message' => '缓存更新完成',
			)
		);
	}

}

/* End of file cli.php */
/* Location: ./application/controllers/cli.php */