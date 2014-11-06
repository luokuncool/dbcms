<?php
class Node extends HOME_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(
        //array('news_model', 'user_model')
        );
    }

    /**
     * 文章主程序
     */
    public function index()
    {
        parent::set_html_header();
        $data['page_title'] = '前台首页';
		$data['data_grid_url'] = '/home/get_json';
        $this->smarty->view('home/node/index.tpl', $data);
    }

	/**
	 * 创建节点
	 */
	public function create()
	{
		if ($_POST) {
			echo 'd';
		} else {
			$this->smarty->view('home/node/create.tpl');
		}
	}

}