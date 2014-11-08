<?php
/**
 * Created by PhpStorm.
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

	//todo 完善缓存更新
	public function update_cache()
	{
		$this->load->driver('cache', array('adapter'=>'redis'));
		while($ids = $this->cache->get('node')) {
			foreach($ids as $key=>$id) {
				$row = $this->db->from('node')->where($id)->get()->row_array();
				$this->cache->delete('node'.$id['id']);
				$row && $result = $this->cache->save('node'.$id['id'], $row, 0);
				if (!$row OR $result) {
					echo 'unset'.$id['id'], "\n";
					unset($ids[$key]);
				}
				//file_put_contents('test', date('Y-m-d H:i:s'), "\n");
				//echo date('Y-m-d H:i:s'), "\n">>'/var/www/whatEver/text.txt';
			}
			$this->cache->delete('node');
			$this->cache->save('node', $ids, 0);
		}
	}

	public function update_cache2()
	{
		$this->load->driver('cache', array('adapter'=>'redis'));
		$ids = $this->cache->get('node');
		foreach($ids as $key=>$id) {
			$row = $this->db->from('node')->where($id)->get()->row_array();
			$this->cache->delete('node'.$id['id']);
			//$result = $this->cache->save('node'.$id['id'], $row, 3000);
			if ($result) {
				echo 'unset'.$id['id'], "\n";
				unset($ids[$key]);
			}
			var_dump($result);
			echo date('Y-m-d H:i:s'), "\n";
		}
		$this->cache->delete('node');
		$this->cache->save('node', $ids, 3000);
	}

}